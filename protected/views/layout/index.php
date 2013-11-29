<?php
/* @var $this LayoutController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Layouts',
);

$this->menu=array(
	array('label'=>'Create Layout', 'url'=>array('create')),
	array('label'=>'Manage Layout', 'url'=>array('admin')),
);
?>

<h1>Layouts</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
