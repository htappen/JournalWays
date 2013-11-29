<?php
/* @var $this TemplateForTablesController */
/* @var $model TemplateForTables */

$this->breadcrumbs=array(
	'Template For Tables'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TemplateForTables', 'url'=>array('index')),
	array('label'=>'Create TemplateForTables', 'url'=>array('create')),
	array('label'=>'View TemplateForTables', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage TemplateForTables', 'url'=>array('admin')),
);
?>

<h1>Update TemplateForTables <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>