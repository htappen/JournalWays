<?php
/* @var $this TemplateForTablesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Template For Tables',
);

$this->menu=array(
	array('label'=>'Create TemplateForTables', 'url'=>array('create')),
	array('label'=>'Manage TemplateForTables', 'url'=>array('admin')),
);
?>

<h1>Template For Tables</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
