<?php
/* @var $this LayoutController */
/* @var $model Layout */

$this->breadcrumbs=array(
	'Layouts'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Layout', 'url'=>array('index')),
	array('label'=>'Create Layout', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('layout-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Layouts</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'layout-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'updateTime',
		'createTime',
		'active',
		'numLandscapePics',
		'numPortraitPics',
		/*
		'pic1pos',
		'pic1isPortrait',
		'pic1widthRatio',
		'pic2pos',
		'pic2isPortrait',
		'pic2widthRatio',
		'pic3pos',
		'pic3isPortrait',
		'pic3WidthRatio',
		'pic4pos',
		'pic4isPortrait',
		'pic4widthRatio',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
