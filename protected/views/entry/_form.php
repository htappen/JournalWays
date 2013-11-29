<?php
/* @var $this EntryController */
/* @var $model Entry */
/* @var $form CActiveForm */
?>
<div class="form">
<p class="note">Fields with <span class="required">*</span> are required.</p>
<?php 
$this->widget('ext.EAjaxUpload.EAjaxUpload',
array(
    'id'=>'uploadFile',
    'config'=>array(
           'action'=>Yii::app()->createUrl('entry/upload'),
           'allowedExtensions'=>array("jpg","jpeg","png","gif"),
           'sizeLimit'=>10*1024*1024,
           'minSizeLimit'=>1024,			   
           'onComplete'=>"js:function(id, filename, responseJSON){   getFilename(filename, responseJSON)  }",
           'messages'=>array(
                             'typeError'=>"{file} has invalid extension. Only {extensions} are allowed.",
                             'sizeError'=>"{file} is too large, maximum file size is {sizeLimit}.",
                             'minSizeError'=>"{file} is too small, minimum file size is {minSizeLimit}.",
                             'emptyError'=>"{file} is empty, please select files again without it.",
                             'onLeave'=>"The files are being uploaded, if you leave now the upload will be cancelled."
                            ),
           'showMessage'=>"js:function(message){ alert(message); }"
        )
));
?>
<link rel="stylesheet" type="text/css" href="/css/css/style.css" />
<link rel="stylesheet" type="text/css" href="/css/css/jWindowCrop.css" />
<link rel="stylesheet" type="text/css" href="/css/css/tipsy.css" />
<script type="text/javascript" src="/scripts/ui/jquery.jWindowCrop.js"></script>
<script type="text/javascript" src="/scripts/ui/tipsy.js"></script>
<script type="text/javascript">

/*
 * Declaration of global variables
 **/
var topOffsetVal = 0;
var leftOffsetVal = 0;
var cropWidth = 0;
var cropHeight =0;
var imageName = "";
var imageState = "no image";

var cropCounter = 1; 
var rotateCounter =0;
var currentID = 0;

var responseWidth=0;
var responseHeight=0; 


/*
 * start script here
 **/
function getFilename(filename, response){
    $('#imgLoad').show();
    $('#cropButton').removeAttr('disabled');
    $('#changeLayout1').removeAttr('disabled');
    $('#changeLayout2').removeAttr('disabled');
    topOffsetVal = 0;
    leftOffsetVal = 0;
    cropWidth = 0;
    cropHeight =0;
    imageName = "";
    imageState = "no image";

    rotateCounter =0;

    responseWidth=0;
    responseHeight=0; 

    $("#thePicture").attr(
        'src',response['filename']
    );             
    currentID = response['id'];
    $('<input type="hidden" name="photo_id[]" id="photo_id" value="'+currentID+'"></div>').appendTo("#img_key");
    
   // console.log(response);    
        
    imageName = response['filename'];
    //console.log(response);
    responseWidth=response['width'];
    responseHeight=response['height'];
    imageState = (responseWidth>=responseHeight)?'landscape':'portrait';
    
    $(".jwc_controls").show();
   
    changeCropper(imageState);
    
    $("#cropButton").show();
    
    $("#rotateOption").show();

    $("#changeLayout1").attr("disabled", false);
    $("#changeLayout2").attr("disabled", false);
    if(imageState == 'landscape')
        $("#changeLayout2").attr('checked','checked');
    else
        $("#changeLayout1").attr('checked','checked');
}


// document load
$(document).ready(function() {		 
    hideshowButtonUpload();
    
    /*
     * If rotate right
     **/
    $('#rotateRight').click(function(){               
        rotatingImage(-1);
        rotateCounter--;
    });
    
    /*
     * if rotate left
     **/
    $('#rotateLeft').click(function(){               
        rotatingImage(1);
        rotateCounter++;
    });
    
    /*
     * if edit the crop image
     **/
    $(".editPrevImage").live('click', function() {
//        var imgPrvHeight=$(".newImagePreview img").height();
//        var imgPrvWidth=$(".newImagePreview img").width();
//        if(imgPrvHeight>=imgPrvWidth){
//            imageState="landscape";
//        }
//        else{
//            imageState="portrait";
//        }
        
        changeCropper(imageState);
        $('#cropButton').removeAttr('disabled');
        $('#changeLayout1').removeAttr('disabled');
        $('#changeLayout2').removeAttr('disabled');
        var id = $(this).attr("id");  
        var sd=$("#imgPrev"+id+"").attr("width");
        alert(sd);
        var imgSrc = getSourceImage($("#imgPrev"+id+"").attr("src"));         
        editImage(imgSrc,id);
        
        
    });               
    
    /*
     * if change the crop image
     **/
    $(".changePrevImage").live('click',function(){
        
        changeCropper(imageState);
        
        $('#cropButton').removeAttr('disabled');
        $('#changeLayout1').removeAttr('disabled');
        $('#changeLayout2').removeAttr('disabled');
        var id = $(this).attr("id");           
        var src = getSourceImage($("#imgPrev"+id+"").attr("src"));
        loadOriginalImage(src,id);                           
        imageName = src;      
    });
    
    /*
     * if delete the preview crop image
     **/    
    $(".deletePrevImage").live('click', function() {
        $('#cropButton').removeAttr('disabled');
        $('#changeLayout1').removeAttr('disabled');
        $('#changeLayout2').removeAttr('disabled');
        var id = $(this).attr("id");
        var src = getSourceImage($("#imgPrev"+id).attr("src"));
        var pid = $("#imgPrev"+id).attr("class");
        deleteImage(src,id,pid);  
        imageName = "";
    });
    
    //disable the radio buttons
    $("#changeLayout1").attr("disabled", true);
    $("#changeLayout2").attr("disabled", true);
    $("#changeLayout3").attr("disabled", true);
    //disable slider
   
    //hide the picture
    $("#thePicture").hide();
    $("#cropButton").hide();
    
    // hide rotate option
    $("#rotateOption").hide(); 
});

// count the preview div's'
function countPrevDivs(){ return $(".imgpreview").length; }
        
// create div thumbs for crop preview  images        
function imageThumbPreview(id,src) {
    if(countPrevDivs() < 4) {
        $('<div class="imgpreview" id="imgpreview'+cropCounter+'"><div class="newImagePreview"><div style="position:absolute; left:5px; "><a href="javascript:;" class="editPrevImage" id="'+cropCounter+'"><img title="Edit" src="/images/icon/edit.png" alt="edit"/></a>&nbsp;<a href="javascript:;" class="changePrevImage" id="'+cropCounter+'"><img  title="Change" src="/images/icon/change.png" alt="change"/></a>&nbsp;<a href="javascript:;" class="deletePrevImage" id="'+cropCounter+'"><img title="Delete" src="/images/icon/delete.png" alt="delete"/></a></div><img src="'+src+'" class="'+id+'" id="imgPrev'+cropCounter+'" height="150" /></div></div>').appendTo("#preview");               
//        $.getScript("/scripts/ui/forTipsy.js",dispTips);
    }
    cropCounter++;             
}

// get the source name of the image
function getSourceImage(src) {          
    var lastPoint = src.lastIndexOf("/")+1;
    return src.substring(lastPoint, src.length);   
}

/*
 * function editIMage
 **/
function editImage(src,id) {       
    
    $("#thePicture").attr('src', src);                     
    imageName = src;//getSourceImage(src);   
    editImageCrop(src,id);
    changeCropper(imageState);    
}
    
/*
 * Function to create a new image
 **/
function createNewImage(){
    $("#thePicture").remove();
    $('<img src="" usemap="#html-map" id="thePicture" class="current-level level" />').appendTo(".jwc_frame");
}

/* 
 * change cropper size
 * */
function changeCropper(size){     
    $("#imgLoad").show();
    imageState = size;
    var cloneSrc = $("#thePicture").attr('src');
    $("#thePicture").remove();
    var clone = "<img src='"+cloneSrc+"' id='thePicture' class='current-level level'/>";
    $("#map").empty();
    $('#map').attr('src', '/images/icon/load.gif');
    $("#map").append(clone);
    if(size=="portrait"){
        $(".map-viewport").animate({"height" : "400px", "width" : "300px"});
        windowCrop(300,400);
    } else if(size=="landscape"){   
        $(".map-viewport").animate({"height" : "300px", "width" : "400px"});
        windowCrop(400,300);       
    }    
}

function windowCrop(tWidth, tHeight) {
    $('#thePicture').jWindowCrop({
        targetWidth: tWidth,
        targetHeight: tHeight,
        loadingText: '',
        onChange: function(result) { 
            topOffsetVal = result.cropY;
            leftOffsetVal = result.cropX;
            cropWidth = result.cropW;
            cropHeight = result.cropH;
        }
    });
}

function hideshowButtonUpload() {                
    if(countPrevDivs() < 4) {
        $(".qq-uploader").show();     
    } else {
        $(".qq-uploader").hide(); 
    } 
}

function removePhotoKeyId($pid) {
    $("#photo_id").each(function(){
        if($(this).val()==$pid) {
            $(this).remove();
        }        
    });
}

</script>
<div id="editImage">
    <div id="page-wrap">
        <img id="imgLoad" style="position: absolute; left: 154px; top: 85px; z-index: 20" src="/images/icon/load.gif"/>
        <div class="block" style="width:300px;">
                <div class="map-viewport">
                        <div id="map">
                                <img src="" usemap="#html-map" id="thePicture" class="current-level level" />
                                
                        </div>				
                </div>
        </div>		
        
        <div id="preview">
            <?php $cropCounter=1; ?>
            <?php if($this->isUpdate > 0): ?>
                <?php foreach($this->photoList as $photo): ?>   
                        <div class="imgpreview" id="imgpreview<?php echo $cropCounter; ?>">
                            <div class="newImagePreview">
                                <div style="position:absolute; left:5px; ">
                                    <a href="javascript:;" class="editPrevImage" id="<?php echo $cropCounter; ?>"><img title="Edit" src="/images/icon/edit.png" alt="edit"/></a>&nbsp;<a href="javascript:;" class="changePrevImage" id="<?php echo $cropCounter; ?>"><img title="Change" src="/images/icon/change.png" alt="change"/></a>&nbsp;<a href="javascript:;" class="deletePrevImage" id="<?php echo $cropCounter; ?>"><img title="Delete" src="/images/icon/delete.png" alt="delete"/></a>
                                </div>
                                <img src="<?php echo $photo['filename']; ?>" class="<?php echo $photo['id']; ?>" id="imgPrev<?php echo $cropCounter; ?>" height="150" />
                            </div>
                        </div>         
                        <?php $cropCounter++; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <div style="float: right;" id="cropPreview"><img src=""/></div>     
        <div style="clear:both;"></div>
        
        <div id="rotateOption">
            <button id="rotateLeft"> << </button>
            <button id="rotateRight"> >> </button>
        </div>

    </div>
    
    <form>
    
    Portrait <input  name="changeLayout" id="changeLayout1" onClick="changeCropper('portrait')" type="radio"/>
    Landscape <input  name="changeLayout" id="changeLayout2" onClick="changeCropper('landscape')" type="radio"/>        

    <input type="hidden" name="topOffset" id="topOffset" value="" />
    <input type="hidden" name="leftOffset" id="leftOffset" value="" />   
    <input type="hidden" name="imageOrientation" id="imageOrientation" value="" />   
    <input type="hidden" name="rotationDegree" id="rotationDegree" value="" />   
    
    
        <?php
           
            echo CHtml::button('Crop',array(
                               'onclick'=>"cropIt();",
                               'id'=>'cropButton',
                       ));
            
        ?>
    </form>
</div>
<?php 
$form=$this->beginWidget('CActiveForm', array(
'id'=>'entry-form',
'enableClientValidation'=>true,
'enableAjaxValidation'=>true,

)); 
?>
<div id="img_key">
    <?php if($this->isUpdate > 0): ?>
            <?php foreach($this->photoList as $photo): ?>   
                    <input type="hidden" name="photo_id[]" id="photo_id" value="<?php echo $photo['id']; ?>">
            <?php endforeach; ?>     
    <?php endif; ?>
</div>
<?php echo $form->errorSummary($model); ?>
    <div class="row">
            <?php echo $form->labelEx($model,'title'); ?>
            <?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>100)); ?>
            <?php echo $form->error($model,'title'); ?>
    </div>

    <div class="row">
            <?php echo $form->labelEx($model,'body'); ?>
            <?php echo $form->textArea($model,'body',array('cols'=>46,'rows'=>5,'maxlength'=>700)); ?>
            <?php echo $form->error($model,'body'); ?>
    </div>
    
    <div class="row">
            <?php echo $form->labelEx($model,'date'); ?>
            <?php
                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'name'=>'date',
                    'language' => 'en',
                        'i18nScriptFile' => 'jquery-ui.min.js', 
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
                    ),
                    'value'=>$model->date,
                    'htmlOptions'=>array(
                        'style'=>'height:20px;'
                    ),
                ));
            ?>
            <?php echo $form->error($model,'date'); ?>
    </div>
    <div class="row buttons">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>
<?php $this->endWidget(); ?>
</div><!-- form -->
<script language="javascript" type="text/javascript">
// crop function     
function cropIt() {            
    var lastPoint = imageName.lastIndexOf("/")+1;
    var imageSrc = imageName.substring(lastPoint, imageName.length);  
    <?php
        echo CHtml::ajax(array(
                'url'=>array('entry/cropImage'),
                'type'=>'get',
                'data'=>array(
                    'topOffset'=>'js:topOffsetVal',
                    'leftOffset'=>'js:leftOffsetVal',
                    'cropWidth'=>'js:cropWidth',
                    'cropHeight'=>'js:cropHeight',
                    'imagename'=>'js:imageSrc',
                    'orientation'=>'js:imageState',
                    'rotations'=>'js:rotateCounter'
                    ),
                'success'=>"function(string){
                    $('#imgLoad').hide();
                    $('#cropButton').attr('disabled','disabled');
                    $('#changeLayout1').attr('disabled','disabled');
                    $('#changeLayout2').attr('disabled','disabled');
                    imageThumbPreview(currentID,string);
                    createNewImage();
                 }"
        ));                               
    ?>        
    hideshowButtonUpload();
}

// function to load original image or change image 
function loadOriginalImage(src,id)
{
<?php
    echo CHtml::ajax(array(
        'url'=>array('entry/loadImage'),
        'type'=>'get',
        'data'=>array(                        
            'imageSrc'=>'js:src'                        
            ),
        'success'=>"function(string){                
            $('#imgpreview'+id).remove();
            $('#thePicture').attr('src', string);                              
            
         }"
    ));
 ?>
 hideshowButtonUpload();
}

// function to load and edit the crop image
function editImageCrop(src,id)
{ 
    $("#imgLoad").hide();
<?php
    echo CHtml::ajax(array(
        'url'=>array('entry/editImage'),
        'type'=>'get',
        'data'=>array(                        
            'imageSrc'=>'js:src'                        
            ),
        'success'=>"function(string){                
            $('#imgpreview'+id).remove();
            $('#thePicture').attr('src', string);                                 
         }"
    ));
 ?>
 hideshowButtonUpload();
}

// function to delete the 3 images original, large and small
function deleteImage(src,id,pid)
{
    $("#imgLoad").hide();
    <?php
        echo CHtml::ajax(array(
            'url'=>array('entry/removeImage'),
            'type'=>'get',
            'data'=>array(                        
                'imageSrc'=>'js:src',      
                'pid'=>'js:pid'
                ),
            'success'=>"function(string){          
                $('#thePicture').attr('src','');     
             }"
        ));
     ?>
     $('#imgpreview'+id).remove();
     removePhotoKeyId(pid);        
     hideshowButtonUpload();
}

// function to rotate the image 
function rotatingImage(num)
{             
    var lastPoint = imageName.lastIndexOf("/")+1;
    var imageSrc = imageName.substring(lastPoint, imageName.length);    
    <?php
        echo CHtml::ajax(array(
                
                'url'=>array('entry/rotateImage'),
                'type'=>'get',
                'data'=>array(                         
                    'imagename'=>'js:imageSrc',
                    'num'=>'js:num'
                    ),
                'success'=>"function(string){
                     
                     $('#thePicture').attr('src', string);   
                     
                }"
        ));                               
    ?>
}        
 </script>
