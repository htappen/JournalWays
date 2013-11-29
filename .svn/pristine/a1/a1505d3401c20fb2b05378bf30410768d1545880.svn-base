<?php
/* @var $this PhotoController */
/* @var $model Photo */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'photo-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'userId'); ?>
		<?php echo $form->textField($model,'userId',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'userId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'updateTime'); ?>
		<?php echo $form->textField($model,'updateTime'); ?>
		<?php echo $form->error($model,'updateTime'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'createTime'); ?>
		<?php echo $form->textField($model,'createTime'); ?>
		<?php echo $form->error($model,'createTime'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'active'); ?>
		<?php echo $form->textField($model,'active'); ?>
		<?php echo $form->error($model,'active'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fileName'); ?>
		<?php echo $form->textField($model,'fileName',array('size'=>60,'maxlength'=>300)); ?>
		<?php echo $form->error($model,'fileName'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fileExtension'); ?>
		<?php echo $form->textField($model,'fileExtension',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'fileExtension'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'bytes'); ?>
		<?php echo $form->textField($model,'bytes'); ?>
		<?php echo $form->error($model,'bytes'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s3Key'); ?>
		<?php echo $form->textField($model,'s3Key',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'s3Key'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s3Bucket'); ?>
		<?php echo $form->textField($model,'s3Bucket',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'s3Bucket'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'isPortrait'); ?>
		<?php echo $form->textField($model,'isPortrait'); ?>
		<?php echo $form->error($model,'isPortrait'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->