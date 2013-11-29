<?php
/* @var $this CoverController */
/* @var $model Cover */

$this->breadcrumbs=array(
	'Covers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Cover', 'url'=>array('index')),
	array('label'=>'Manage Cover', 'url'=>array('admin')),
);
?>

<h1>Create Cover</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>