<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Registration");
$this->breadcrumbs=array(
	UserModule::t("Registration"),
);
?>

<h1><?php echo UserModule::t("Registration"); ?></h1>


      
<?php $this->widget('ext.yii-facebook-opengraph.plugins.Registration', array(
   'redirect_uri'=>Yii::app()->request->hostInfo."/user/fbRegistration",
    'fields'=>'name,email,first_name,last_name'
)); ?>
