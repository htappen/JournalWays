<?php
/* @var $this LayoutController */
/* @var $model Layout */

$this->breadcrumbs=array(
	'Layouts'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Layout', 'url'=>array('index')),
	array('label'=>'Create Layout', 'url'=>array('create')),
	array('label'=>'Update Layout', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Layout', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Layout', 'url'=>array('admin')),
);
?>

<h1>View Layout #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'updateTime',
		'createTime',
		'active',
		'numLandscapePics',
		'numPortraitPics',
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
	),
)); ?>
