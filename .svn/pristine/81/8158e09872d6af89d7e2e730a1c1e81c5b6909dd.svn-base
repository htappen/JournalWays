<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Registration");
$this->breadcrumbs=array(
	UserModule::t("Registration"),
);
?>

<h1><?php echo UserModule::t("Registration"); ?></h1>

<?php if(Yii::app()->user->hasFlash('registration')): ?>
<div class="success">
<?php echo Yii::app()->user->getFlash('registration'); ?>
</div>
<?php else: ?>

<div class="form">
<?php $form=$this->beginWidget('UActiveForm', array(
	'id'=>'registration-form',
	'enableAjaxValidation'=>true,
	'disableAjaxValidationAttributes'=>array('RegistrationForm_verifyCode'),
	'htmlOptions' => array('enctype'=>'multipart/form-data'),
)); ?>

	<p class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>
	
	<?php echo $form->errorSummary(array($model)); ?>
	
	<div class="row">
	<?php echo $form->labelEx($model,'username'); ?>
	<?php echo $form->textField($model,'username'); ?>
	<?php echo $form->error($model,'username'); ?>
	</div>
	
	<div class="row">
	<?php echo $form->labelEx($model,'password'); ?>
	<?php echo $form->passwordField($model,'password'); ?>
	<?php echo $form->error($model,'password'); ?>
	<!--<p class="hint">
	<?php echo UserModule::t("Minimal password length 6 symbols and must contain at least one number."); ?>
	</p>-->
	</div>
	
	<div class="row">
	<?php echo $form->labelEx($model,'verifyPassword'); ?>
	<?php echo $form->passwordField($model,'verifyPassword'); ?>
	<?php echo $form->error($model,'verifyPassword'); ?>
	</div>
	
	<div class="row">
	<?php echo $form->labelEx($model,'email'); ?>
	<?php echo $form->textField($model,'email'); ?>
	<?php echo $form->error($model,'email'); ?>
	</div>
	
        
       
        <div class="row">
            <br/>
            <?php echo $form->checkBox($model,"EULA"); ?>
            I have read and agree to the   <?php  echo CHtml::link('Terms and conditions', array('/user/eula'), array('style'=>'color:blue;text-decoration:underline')); ?> <a></a>
            <?php echo $form->error($model,'EULA'); ?>
            <br/>
        </div>
        
	<?php if (UserModule::doCaptcha('registration')){ ?>
	<div class="row">
		<?php echo $form->labelEx($model,'verifyCode'); ?>
		
		<?php $this->widget('CCaptcha'); ?>
		<?php echo $form->textField($model,'verifyCode'); ?>
		<?php echo $form->error($model,'verifyCode'); ?>
		
		<p class="hint"><?php echo UserModule::t("Please enter the letters as they are shown in the image above."); ?>
		<br/><?php echo UserModule::t("Letters are not case-sensitive."); ?></p>
	</div>
	<?php } ?>
	
	<div class="row submit">
		<?php echo CHtml::submitButton(UserModule::t("Register")); ?>
	</div>
        
<fb:registration redirect-uri="<?php echo Yii::app()->request->hostInfo."/user/fbRegistration";?>" 
  fields='[{"name":"name"},
            {"name":"email"},
            {"name":"first_name"},
            {"name":"last_name"},
           {"name":"username","description":"Username","type":"text"},
           {"name":"password"}
           ]'
           
  onvalidate="validate_async"></fb:registration> 

<script> 
function validate_async(form, cb) {
  $.getJSON('<?php echo Yii::app()->request->hostInfo."/user/fbRegistration/checkName?userName=";?>'+ form.username, 
    function(response) {
        console.log(response);
      if (response.error) {
        // Username isn't taken, let the form submit
        cb();
      }
      cb({username: response.username});
  });
}
</script> 
<?php $this->endWidget(); ?>
</div><!-- form -->
<?php endif; ?>