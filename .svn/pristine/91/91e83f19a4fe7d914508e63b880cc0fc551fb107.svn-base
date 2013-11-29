<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Login"); ?>

<h1><?php echo $title; ?></h1>

<div class="form">
<?php echo $content; ?>

</div><!-- yiiForm -->
<br/>
<?php
 
if( isset($registrationSuccess) && $registrationSuccess ){
    

    $this->renderPartial('/user/login',   // the "//" allows you to go to the views folder outside this module!
                array('model' =>new UserLogin,
            ));
}
    ?>
    