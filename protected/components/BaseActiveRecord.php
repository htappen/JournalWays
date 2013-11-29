<?php


/**
 * Description of TimeActiveRecord
 *
 * @author TekVitals
 */
class BaseActiveRecord extends CActiveRecord {
    //put your code here
    
    public function defaultScope()
    {
        return array(
            'condition'=>"userId = ".Yii::app()->user->id,
        );
    }
    public function beforeSave(){
        if(parent::beforeSave()){
        if($this->userId==Yii::app()->user->id)
            return true;
        else
            return false;
        }   
    }
    
}

?>
