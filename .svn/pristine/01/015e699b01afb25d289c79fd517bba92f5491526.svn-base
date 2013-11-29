<?php

class ActivationController extends Controller
{

        /**
         * Associate the default modules with the newly activated user
         * so the user has access to those modules.
         * 
         * @param $entId: int - user entity id
         * @return null
    
	
	/**
	 * Activation user account
	 */
	public function actionActivation () { 
        if(!Yii::app()->user->isGuest)
                $this->redirect(array('/site/index'));
        else{
            
		$email = $_GET['email'];
		$activKey = $_GET['activKey'];
		if ($email&&$activKey) {
			$find = User::model()->notsafe()->findByAttributes(array('email'=>$email));
			if (isset($find)&&$find->active) {
			    $this->render('/user/message',
                                    array('title'=>UserModule::t(""),
                                        'content'=>UserModule::t("</br><div class='flash-success'>Your account is already active.
                                            You are free to login.</div>"),
                                        'registrationSuccess'=>true,
                                        ));

			} else if(isset($find->activKey) && ($find->activKey==$activKey)) {

                               
                                
				$find->activKey = UserModule::encrypting(microtime());
				$find->active = 1;
                               // $find->entityId=$find->id;
                                //$find->roleId = $userRole->id;
                                //print_r($find->attributes);
                               // $ent_id=$find->id;
                                $date=new CDbExpression('NOW()');
//                                $firstMonth = new Months();
//                                $firstMonth->date = $date;
//                                $firstMonth->entity = $ent_id;
//                                $firstMonth->referrer = 1;
//                                $firstMonth->promotion = 2;
//                                $firstMonth->save();
                                
                                
                            
                                $find->save();

                            
			   $this->render('/user/message',
                                   array('title'=>UserModule::t(""),
                                       'content'=>UserModule::t("<div class='flash-success'>Your account is now activated and you can login.</div>"),
                                       'registrationSuccess'=>true,
                                   ));
			} else {
			    $this->render('/user/message',
                                    array('title'=>UserModule::t("User activation"),
                                        'content'=>UserModule::t("<div class='flash-error'>Incorrect activation URL.</div>"),
                                        'registrationSuccess'=>false
                                        ));
			}
		} else {
			$this->render('/user/message',
                                array('title'=>UserModule::t("User activation"),
                                    'content'=>UserModule::t("<div class='flash-error'>Incorrect activation URL.</div>"),
                                    'registrationSuccess'=>false,
                                    ));
		}
	
            }
        }
        

}