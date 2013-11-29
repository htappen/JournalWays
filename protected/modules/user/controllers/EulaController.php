<?php

class EulaController extends Controller
{
	public $defaultAction = 'eula';
        public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}
	public function accessRules()
	{
		return array(
                        array('allow',
                                'actions'=>array('eula'),
                                'users'=>array('*'),
                        ),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Declares class-based actions.
	 */
	 public function actionEula(){
            $this->render('/user/eula');
        }
	/**
	 * Registration user
	 */
	
}