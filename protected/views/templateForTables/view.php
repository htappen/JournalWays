<?php
/* @var $this TemplateForTablesController */
/* @var $model TemplateForTables */

$this->breadcrumbs=array(
	'Template For Tables'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List TemplateForTables', 'url'=>array('index')),
	array('label'=>'Create TemplateForTables', 'url'=>array('create')),
	array('label'=>'Update TemplateForTables', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete TemplateForTables', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TemplateForTables', 'url'=>array('admin')),
);
?>

<h1>View TemplateForTables #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'userId',
		'updateTime',
		'createTime',
		'active',
	),
)); ?>
