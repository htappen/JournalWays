<?php

class RegistrationController extends Controller
{
	public $defaultAction = 'registration';
	


	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return (isset($_POST['ajax']) && $_POST['ajax']==='registration-form')?array():array(
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
		);
	}
	/**
	 * Registration user
	 */
	public function actionRegistration() {
            
            $model = new RegistrationForm('registration');
           
            
			// ajax validator
			if(isset($_POST['ajax']) && $_POST['ajax']==='registration-form')
			{
				echo UActiveForm::validate(array($model));
				Yii::app()->end();
			}
			
		    if (Yii::app()->user->id) {
		    	$this->redirect(Yii::app()->controller->module->returnUrl);
		    } else {
		    	if(isset($_POST['RegistrationForm'])) {
					$model->attributes=$_POST['RegistrationForm'];
					if($model->validate())
					{
						$soucePassword = $model->password;
                                                $model->salt=  sha1(uniqid());
						$model->activKey=UserModule::encrypting(microtime(),$model->password);
						$model->password=UserModule::encrypting($model->password,$model->salt);
						$model->verifyPassword=UserModule::encrypting($model->verifyPassword,$model->salt);
                                                $model->createTime=new CDbExpression('NOW()');
						$model->updateTime=((Yii::app()->controller->module->loginNotActiv||(Yii::app()->controller->module->activeAfterRegister&&Yii::app()->controller->module->sendActivationMail==false))&&Yii::app()->controller->module->autoLogin)?new CDbExpression('NOW()'):0;
						$model->active=((Yii::app()->controller->module->activeAfterRegister)?User::STATUS_ACTIVE:User::STATUS_NOACTIVE);
						
						if ($model->save()) {
							if (Yii::app()->controller->module->sendActivationMail) {
                                                                 Yii::import('ext.sesEmail.sesEmail');
                                                                 $mail = new sesEmail();
								$activation_url = $this->createAbsoluteUrl('/user/activation/activation',array("activKey" => $model->activKey, "email" => $model->email));
								$mail->sendMail($model->email,UserModule::t("Welcome to {site_name}",array('{site_name}'=>Yii::app()->name)),UserModule::t("Welcome to Journal on the Go. Please activate your account here {activation_url}",array('{activation_url}'=>$activation_url)));
							}
							
							if ((Yii::app()->controller->module->loginNotActiv||(Yii::app()->controller->module->activeAfterRegister&&Yii::app()->controller->module->sendActivationMail==false))&&Yii::app()->controller->module->autoLogin) {
									$identity=new UserIdentity($model->username,$soucePassword);
									$identity->authenticate();
									Yii::app()->user->login($identity,0);
									$this->redirect(Yii::app()->controller->module->returnUrl);
							} else {
								if (!Yii::app()->controller->module->activeAfterRegister&&!Yii::app()->controller->module->sendActivationMail) {
									Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Contact Admin to activate your account."));
								} elseif(Yii::app()->controller->module->activeAfterRegister&&Yii::app()->controller->module->sendActivationMail==false) {
									Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Please {{login}}.",array('{{login}}'=>CHtml::link(UserModule::t('Login'),Yii::app()->controller->module->loginUrl))));
								} elseif(Yii::app()->controller->module->loginNotActiv) {
									Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Please check your email or login."));
								} else {
									Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Please check your email."));
								}
								$this->refresh();
							}
						}
					}
				}
                                
                                $model->password = null;
                                $model->verifyPassword = null;
                                     $this->render('/user/registration',array('model'=>$model));
		    }
	}
}