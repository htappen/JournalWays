<?php


class FbLoginController extends Controller
{
	public $defaultAction = 'fbLogin';

	/**
	 * Displays the login page
	 */
	public function actionFbLogin()
	{
$model=new UserLogin('fbLogin');
            
		if (Yii::app()->user->isGuest) {
			
			// collect user input data
                         $facebook_id = Yii::app()->facebook->getUser();
                            if ($facebook_id) { // check that you get a Facebook ID before calling api()
                              $user=User::model()->fblogin()->findByAttributes(array('facebookId'=>$facebook_id));
                              if(isset($user)&&isset($user->facebookId)){
                                  $model->facebookId=$user->facebookId;
                                 
                                  if($model->validate()){
                                     $this->redirect(Yii::app()->user->returnUrl);
                                     return;
                                }
                              }
                              $this->redirect(Yii::app()->getModule('user')->fbRegistrationUrl);
                            }
			// display the login form
                        
			$this->redirect(Yii::app()->getModule('user')->loginUrl);
		} else
			$this->redirect(Yii::app()->controller->module->returnUrl);
	}
	
	private function lastViset() {
		$lastVisit = User::model()->notsafe()->findByPk(Yii::app()->user->id);
		$lastVisit->updateTime = time();
		$lastVisit->save();
	}

}

?>
