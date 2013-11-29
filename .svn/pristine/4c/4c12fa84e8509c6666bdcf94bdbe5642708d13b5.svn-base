<?php
/* @var $this CoverController */
/* @var $model Cover */

$this->breadcrumbs=array(
	'Covers'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Cover', 'url'=>array('index')),
	array('label'=>'Create Cover', 'url'=>array('create')),
	array('label'=>'View Cover', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Cover', 'url'=>array('admin')),
);
?>

<h1>Update Cover <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>