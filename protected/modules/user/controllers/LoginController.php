<?php

class LoginController extends Controller
{
	public $defaultAction = 'login';

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
            
		if (Yii::app()->user->isGuest) {
			
			// collect user input data
                        $model=new UserLogin('login');
			if(isset($_POST['UserLogin']))
			{
                            
				$model->attributes=$_POST['UserLogin'];
				// validate user input and redirect to previous page if valid
				if($model->validate()) {
                                    //check expiration status
//                                        $user = User::model()->findByAttributes(array('username'=>$model->username));
//                                      
//                                        $date = new DateTime($user->getExpiration());
//                                        if($date>new DateTime()){
//                                            $this->lastViset();
//                                            if (strpos(Yii::app()->user->returnUrl,'/index.php')!==false)
//                                                    $this->redirect(Yii::app()->controller->module->returnUrl);
//                                            else
                                                    $this->redirect(Yii::app()->user->returnUrl);
//                                        }
//                                        else{
////                                            $user->roleId=2;
////                                            $user->save();
//                                            $this->redirect('/admin/index');
//                                        }
				}
			}
			// display the login form
                     
			$this->render('/user/login',array('model'=>$model));
		} else
			$this->redirect(Yii::app()->controller->module->returnUrl);
	}
	
	private function lastViset() {
		$lastVisit = User::model()->notsafe()->findByPk(Yii::app()->user->id);
		$lastVisit->updateTime = time();
		$lastVisit->save();
	}

}