<?php
/* @var $this CoverController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Covers',
);

$this->menu=array(
	array('label'=>'Create Cover', 'url'=>array('create')),
	array('label'=>'Manage Cover', 'url'=>array('admin')),
);
?>

<h1>Covers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
