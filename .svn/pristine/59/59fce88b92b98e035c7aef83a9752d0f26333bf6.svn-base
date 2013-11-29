<?php
/* @var $this CoverController */
/* @var $model Cover */

$this->breadcrumbs=array(
	'Covers'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Cover', 'url'=>array('index')),
	array('label'=>'Create Cover', 'url'=>array('create')),
	array('label'=>'Update Cover', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Cover', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Cover', 'url'=>array('admin')),
);
?>

<h1>View Cover #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		's3Key',
		'userId',
		'updateTime',
		'createTime',
		'active',
	),
)); ?>
