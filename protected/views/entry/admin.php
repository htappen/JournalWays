<style type="text/css">
   .lighted a{
        background-color: Green !important;
        background-image :none !important;
        color: White !important;
        font-weight:bold !important;
        font-size: 10pt;
}
    a.ui-state-active {
        background-color: Black !important;
        background-image :none !important;
        color: White !important;
        font-weight:bold !important;
        font-size: 10pt;
        
    }
  
        
    
</style>
<?php

$titleAndDate=Entry::model()->findAll();
foreach($titleAndDate as $event){
    $SelectedDates[$event->date]=isset($SelectedDates[$event->date])?$SelectedDates[$event->date].','.$event->title:$event->title;        
}
//echo '<pre>';
//print_r($SelectedDates);
//
echo"<script type='text/javascript'>
    var SelectedDates = {};\n";

foreach($SelectedDates as $key => $value) {
    $new_date=date("m/d/Y",strtotime($key));
    echo "\n SelectedDates[";
    echo "new Date('".$new_date."')]".'="'.$value.'";';
    
}
echo "</script>";
/* @var $this EntryController */
/* @var $model Entry */

$this->breadcrumbs=array(
	'Entries'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Entry', 'url'=>array('index')),
	array('label'=>'Create Entry', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('entry-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Entries</h1>

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
	'id'=>'entry-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
        'afterAjaxUpdate' => 'reinstallDatePicker', 
	'columns'=>array(
                 array(
                    'name' => 'date',
                    'filter' => $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'model'=>$model, 
                        'attribute'=>'date',
                        'language' => 'en',
                        'i18nScriptFile' => 'jquery.ui.datepicker-en.js', 
                        'htmlOptions' => array(
                            'id' => 'date_Datepicker',
                            'size' => '12',
                        ),
                        'defaultOptions' => array(  
                            'showOn' => 'focus', 
                            'dateFormat' => 'yy-mm-dd',
                            'showOtherMonths' => true,
                            'selectOtherMonths' => true,
                            'changeMonth' => true,
                            'changeYear' => true,
                            'beforeShowDay' => 'js:function(date){
                                     
                                    var Highlight = SelectedDates[date];
                                    if (Highlight) {
                                        return [true, "lighted", Highlight];
                                    }
                                    else {
                                        return [true, "", ""];
                                    }
                                    
                               }',
                        )
                    ), 
                    true), 
                     
                     ),
            
                'title',
		/*'id',
		'body',
		'userId',
		'updateTime',
		'createTime',
		'active',
		*/
                array(
                    'type'=>'html',
                    'value'=>'CHtml::image("http://s3.amazonaws.com/".$data->photos[0]->s3Bucket."/".$data->photos[0]->s3Key,"tulips",array("style"=>"width:25px;height:25px;"))',
                ),
		array(
			'class'=>'CButtonColumn',
		),
	),
));

Yii::app()->clientScript->registerScript('re-install-date-picker', "
function reinstallDatePicker(id, data) {
    $('#date_Datepicker').datepicker();
}
");


?>

