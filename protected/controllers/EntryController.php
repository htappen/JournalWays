<?php
class EntryController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
 
        /**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','view','create','update','upload','deletePhoto','admin','delete'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
        
        /*Eajaxupload*/
        public function actionUpload()
	{
            Yii::import("ext.EAjaxUpload.qqFileUploader");
            $folder='upload/';// folder for uploaded files
            $allowedExtensions = array("jpg","jpeg");//array("jpg","jpeg","gif","exe","mov" and etc...
            $sizeLimit = 10 * 1024 * 1024;// maximum file size in bytes
            $minSizeLimit=1024;
            //$mySize = new qqUploadedFileForm();								
            $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
            $result = $uploader->handleUpload($folder);
            if($result['success']){
                $s3Name = Yii::app()->user->id."_".time().'.'.$result['ext'];
                $s3Bucket = $_SERVER['HTTP_HOST'];
               
                $success = Yii::app()->s3->upload( 'upload/'.$result['filename'] ,$s3Name , $s3Bucket."_upload" );
                if($success){                    
                     // original image                    
                    $orientation = ($result['width'] > $result['height']) ? 0 : 1;                                        
                    $photo = new Photo();
                    $photo->bytes= filesize('upload/'.$result['filename']);
                    unlink('upload/'.$result['filename']); 
                    $photo->fileName = $result['filename'];
                    $photo->fileExtension = $result['ext'];
                    $photo->s3Key = $s3Name;
                    $photo->s3Bucket = $s3Bucket;
                    $photo->isPortrait = $orientation;
                    $photo->userId = Yii::app()->user->id;
                    $photo->save();  
                    $result['id'] = $photo->id; 
                    $result['filename']="http://s3.amazonaws.com/".$s3Bucket."_upload/$s3Name";
                }
                else {
                     unlink('upload/'.$result['filename']);
                     $result= array('error'=>'Amazon s3 failed to save file');
                }
                $return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);
            }	
            echo $return;// it's array			
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
            $this->render('view',array(
                    'model'=>$this->loadModel($id),
            ));
	}
                        
       
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
            $model=new Entry;

            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);

            if(isset($_POST['Entry']))
            {     
                
                $model->attributes=$_POST['Entry'];                              
                $model->date = $_POST['date'];                
                $model->userId = Yii::app()->user->id;
                $model->updateTime = time();
                $model->createTime = time();
                $model->photo_id = isset($_POST['photo_id']) && count($_POST['photo_id']) > 0 ? true : null;
                $model->active = 1;
                
                if($model->save()) {
                  
                    if(!empty($_POST['photo_id'])) {                    
                        foreach($_POST['photo_id'] as $val) {
                            $photoObject = json_decode($val,true); 
                            
                            $photo=Photo::model()->findByPk($photoObject['photoId']);
                            if(isset($photo)&&isset($photo->user)){
                            // save large image
                                $this->imageResize("large",$photo->s3Key,1600,1200,$photoObject['imageState'],$photoObject['cropWidth'],$photoObject['cropHeight'],$photoObject['topOffsetVal'],$photoObject['leftOffsetVal'],$photoObject['rotateValue']);

                                // save small image
                                $this->imageResize("small",$photo->s3Key,400,300,$photoObject['imageState'],$photoObject['cropWidth'],$photoObject['cropHeight'],$photoObject['topOffsetVal'],$photoObject['leftOffsetVal'],$photoObject['rotateValue']);                                                

                                $photoEntry = new EntryHasPhoto();
                                $photoEntry->entryId = $model->id;
                                $photoEntry->photoId = $photoObject['photoId'];
                                $photoEntry->save();
                            }
                        }
                    }
                
                    $this->redirect(array('view','id'=>$model->id));   
                }
            } 

            $this->render('create',array(
                    'model'=>$model,
            ));
	}
    
     
        public function imageResize($bucketSize,$fileName,$newWidth,$newHeight,$orientation,$cropWidth,$cropHeight,$topOffset,$leftOffset,$rotate)
        {
            Yii::import('application.extensions.image.Image');
            $ornewWidth = 0;
            $ornewHeight = 0;
            if($orientation == 'portrait'){
                $ornewWidth = $newHeight;
                $ornewHeight = $newWidth;                
            } else {
                $ornewWidth = $newWidth;
                $ornewHeight = $newHeight;              
            }
            
            $bucket = $_SERVER['HTTP_HOST'];
            
            
            file_put_contents('upload/'.$fileName, file_get_contents("http://s3.amazonaws.com/".$bucket."_upload/".$fileName));
            
            $image = Yii::app()->image->load("upload/".$fileName);
            
            $image->rotate($rotate*90);
            $image->crop($cropWidth,$cropHeight,$topOffset,$leftOffset); 
            
            $image->resize($ornewWidth,$ornewHeight);
            $image->save("upload/".$fileName); 
            
            Yii::app()->s3->upload( 'upload/'.$fileName ,$fileName,$bucket."_".$bucketSize);
            unlink('upload/'.$fileName);
                                    
            // load small image
            if($newWidth < 500)
                echo "http://s3.amazonaws.com/".$bucket."_".$bucketSize."/".$fileName;
        }
        
          public function actionDeletePhoto()
        {
              
            $pid = $_GET['id'];
            $photo = Photo::model()->findByPk($pid);    // our Id
            $domain=$photo->s3Bucket;
            $imgSrc=$photo->s3Key;
            $photo->delete();   // Delete
            $bucketsArray = array( $domain.'_upload', $domain.'_large', $domain.'_small' );
            $this->deleteObjectArray($bucketsArray, $imgSrc);
            
        }
        
        private function deleteObjectArray($bucketsArray,$imgSrc) {
            foreach($bucketsArray as $bucket) {
                Yii::app()->s3->deleteObject($bucket,$imgSrc);  
            } 
        }
        
        
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */                                                        
                   
          
	public function actionUpdate($id)
	{
            Yii::import('application.extensions.image.Image');
            $model=$this->loadModel($id);         
            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);                        
            $id_array = array();
            $domain=$_SERVER['HTTP_HOST'];
            $s3BucketSmall = "http://s3.amazonaws.com/".$domain."_small/";
            $s3BucketOrig = "http://s3.amazonaws.com/".$domain."_upload/";
            
         
            if(isset($_POST['Entry']))
            {                
                $model->attributes=$_POST['Entry'];
                $model->photo_id = (isset($_POST['photo_id']) && count($_POST['photo_id']) > 0)||count($model->photos)>=1 ? true : null;   
                if($model->save()) {       
                    if(!empty($_POST['photo_id'])) {                    
                        foreach($_POST['photo_id'] as $val) {                            
                            $photoObject = json_decode($val,true); 
                            
                            $photo=Photo::model()->findByPk($photoObject['photoId']);
                            if(isset($photo)&&isset($photo->user)){
                            // save large image
                                $this->imageResize("large",$photo->s3Key,1600,1200,$photoObject['imageState'],$photoObject['cropWidth'],$photoObject['cropHeight'],$photoObject['topOffsetVal'],$photoObject['leftOffsetVal'],$photoObject['rotateValue']);

                                // save small image
                                $this->imageResize("small",$photo->s3Key,400,300,$photoObject['imageState'],$photoObject['cropWidth'],$photoObject['cropHeight'],$photoObject['topOffsetVal'],$photoObject['leftOffsetVal'],$photoObject['rotateValue']);                                                

                                $photoEntry = new EntryHasPhoto();
                                $photoEntry->entryId = $model->id;
                                $photoEntry->photoId = $photoObject['photoId'];
                                $photoEntry->save();
                            }
                        }
                    }
                    $this->redirect(array('view','id'=>$model->id));
                }
            }
            $this->render('update',array(
                    'model'=>$model,
            )); 
	}        
        
        
        
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */                
        
	public function actionIndex()
	{
            $dataProvider=new CActiveDataProvider('Entry');
            $this->render('index',array(
                    'dataProvider'=>$dataProvider,
            ));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Entry();
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Entry']))
			$model->attributes=$_GET['Entry'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Entry::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='entry-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        
        
}
