<?php


/**
 * Description of TimeActiveRecord
 *
 * @author TekVitals
 */
class TimeActiveRecord extends BaseActiveRecord {
    //put your code here
    
    public function beforeSave() {
        if ($this->isNewRecord) 
            $this->createTime = new CDbExpression('NOW()');
        
        $this->updateTime = new CDbExpression('NOW()');
        
        return parent::beforeSave();
    }
    
}

?>
