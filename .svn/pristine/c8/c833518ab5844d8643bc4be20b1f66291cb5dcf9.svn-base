<?php
class FbRegistrationController extends Controller {
    

    public $defaultAction = 'fbRegistration';
   public function actionFbRegistration(){
     $model = new RegistrationForm('fbregistration');
            if ($_REQUEST) {
       $response = $this->parse_signed_request($_REQUEST['signed_request'], 
                                   'f7fa167ed5e821e6f5d8f70ffe4a0446');
           if(isset($response)){
               
                 
                 $model->captchaScope="fbregistration";
		    if (Yii::app()->user->id) {
		    	$this->redirect(Yii::app()->controller->module->returnUrl);
		    } else {
                         if(isset($response['registration'])) {
                                        $user=User::model()->fblogin()->findByAttributes(array('facebookId'=>$response['user_id']));
                                        if(isset($user)&&isset($user->facebookId))
                                        $user->delete();
					$model->attributes=$response['registration'];
                                        $model->firstName=$response['registration']['first_name'];
                                        $model->lastName=$response['registration']['last_name'];
                                        $model->facebookId=$response['user_id'];
					if($model->validate('fbregistration'))
					{       $soucePassword=$model->password;
                                                $model->salt=  sha1(uniqid());
						$model->activKey=UserModule::encrypting(microtime(),$model->password);
//						$model->password=UserModule::encrypting($model->password,$model->salt);
                                                $model->createTime=new CDbExpression('NOW()');
						$model->updateTime=((Yii::app()->controller->module->loginNotActiv||(Yii::app()->controller->module->activeAfterRegister&&Yii::app()->controller->module->sendActivationMail==false))&&Yii::app()->controller->module->autoLogin)?new CDbExpression('NOW()'):0;
						$model->active=1;
						
						if ($model->save()) {
//							if (Yii::app()->controller->module->sendActivationMail) {
//                                                                 Yii::import('ext.sesEmail.sesEmail');
//                                                                 $mail = new sesEmail();
//								$activation_url = $this->createAbsoluteUrl('/user/activation/activation',array("activKey" => $model->activKey, "email" => $model->email));
//								$mail->sendMail($model->email,UserModule::t("Welcome to {site_name}",array('{site_name}'=>Yii::app()->name)),UserModule::t("Welcome to Journal on the Go. Please activate your account here {activation_url}",array('{activation_url}'=>$activation_url)));
//							}
							
//							if ((Yii::app()->controller->module->loginNotActiv||(Yii::app()->controller->module->activeAfterRegister&&Yii::app()->controller->module->sendActivationMail==false))&&Yii::app()->controller->module->autoLogin) {
									$identity=new FbUserIdentity($model->facebookId);
									$identity->authenticate();
									Yii::app()->user->login($identity,0);
									$this->redirect(Yii::app()->controller->module->returnUrl);
//							} else {
//								if (!Yii::app()->controller->module->activeAfterRegister&&!Yii::app()->controller->module->sendActivationMail) {
//									Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Contact Admin to activate your account."));
//								} elseif(Yii::app()->controller->module->activeAfterRegister&&Yii::app()->controller->module->sendActivationMail==false) {
//									Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Please {{login}}.",array('{{login}}'=>CHtml::link(UserModule::t('Login'),Yii::app()->controller->module->loginUrl))));
//								} elseif(Yii::app()->controller->module->loginNotActiv) {
//									Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Please check your email or login."));
//								} else {
//									Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Please check your email."));
//								}
//								$this->refresh();
//							}
						}
					}
				}
                                
                                $model->password = null;
                                $model->verifyPassword = null;
                                     $this->render('/user/fbRegistration',array('model'=>$model));
		    }
                    
          } else {
            throw new CHttpException(403, 'Forbidden');
          }
          
        }
        $this->render('/user/fbRegistration',array('model'=>$model));
   }
   /*public function actionCheckName(){
       $a->success=true;
       if(isset($_GET['userName']))
            {
           $u = User::model()->find('username=:uname', array(':uname'=>$_GET['userName']));
                    if($u!=null){
                        $a->username='That Username is already taken.';
                        $a->success=false;
                    }
            }
        print json_encode($a);
                    return;
            
   }*/
protected function parse_signed_request($signed_request, $secret) {
 list($encoded_sig, $payload) = explode('.', $signed_request, 2); 

  // decode the data
  $sig = $this->base64_url_decode($encoded_sig);
  $data = json_decode($this->base64_url_decode($payload), true);
  if (strtoupper($data['algorithm']) !== 'HMAC-SHA256') {
    error_log('Unknown algorithm. Expected HMAC-SHA256');
    echo "Unkown algorithm";
    return null;
  }

  // Adding the verification of the signed_request below
  $expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
  if ($sig !== $expected_sig) {
    error_log('Bad Signed JSON signature!');
    
    return null;
  }
  return $data;
}
 protected function base64_url_decode($input) {
        return base64_decode(strtr($input, '-_', '+/'));
    }
}
?>
