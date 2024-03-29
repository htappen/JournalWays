/*
 * jWindowCrop v1.0.0
 *
 * Copyright (c) 2012 Tyler Brown
 * Licensed under the MIT license.
 *
 */



(function($){
	function fillContainer(val,min, targetLength, containerLength) { // ensure that no gaps are between target's edges and container's edges
                if(val + targetLength< containerLength+min) 
                    val = (containerLength-targetLength)+min;
		if(val > min) val = min;
		return val;
	}

	$.jWindowCrop = function(image, options){
		var base = this;
		base.$image = $(image); // target image jquery element
		base.image = image; // target image dom element
		base.$image.data("jWindowCrop", base); // target frame jquery element

		base.namespace = 'jWindowCrop';
		base.originalWidth = 0;
		base.isDragging = false;
		
		base.init = function(){
			base.$image.css({display:'none'}); // hide image until loaded
			base.options = $.extend({},$.jWindowCrop.defaultOptions, options);
			if(base.options.zoomSteps < 2) base.options.zoomSteps = 2;

			base.$image.addClass('jwc_image').wrap('<div class="jwc_frame" />'); // wrap image in frame
			base.$frame = base.$image.parent();
			base.$frame.append(base.options.loadingText);
			base.$frame.append('<div class="jwc_controls" style="display:'+(base.options.showControlsOnStart ? 'block' : 'none')+';"><span>click to drag</span><a href="#" class="jwc_zoom_in"></a><a href="#" class="jwc_zoom_out"></a></div>');
			base.$frame.css({'overflow': 'hidden', 'position': 'relative', 'width': base.options.targetWidth, 'height': base.options.targetHeight});
			base.$image.css({'position': 'absolute', 'top': '0px', 'left': '0px'});
			initializeDimensions();

			base.$frame.find('.jwc_zoom_in').on('click.'+base.namespace, base.zoomIn);
			base.$frame.find('.jwc_zoom_out').on('click.'+base.namespace, base.zoomOut);
			base.$frame.on('mouseenter.'+base.namespace, handleMouseEnter);
			base.$frame.on('mouseleave.'+base.namespace, handleMouseLeave);
			base.$image.on('load.'+base.namespace, handeImageLoad);
			base.$image.on('mousedown.'+base.namespace, handleMouseDown);
			$(document).on('mousemove.'+base.namespace, handleMouseMove);
			$(document).on('mouseup.'+base.namespace, handleMouseUp);
		};

		base.setZoom = function(percent) {
			if(base.minPercent >= 1) {
				percent = base.minPercent;
			} else if(percent > 1.0) {
				percent = 1;
			} else if(percent < base.minPercent) {
				percent = base.minPercent;	
			}
                        if(Math.abs(base.options.rotations)%2)
                            base.$image.height(Math.ceil(base.originalWidth*percent));
                        else
			base.$image.width(Math.ceil(base.originalWidth*percent));
			base.workingPercent = percent;
			focusOnCenter();
			updateResult();
		};
		base.zoomIn = function() {
			var zoomIncrement = (1.0 - base.minPercent) / (base.options.zoomSteps-1);
			base.setZoom(base.workingPercent+zoomIncrement);
			return false;
		};
		base.zoomOut = function() {
			var zoomIncrement = (1.0 - base.minPercent) / (base.options.zoomSteps-1);
			base.setZoom(base.workingPercent-zoomIncrement);
			return false;
		};

		function initializeDimensions() {
			if(base.originalWidth == 0) {
				base.originalWidth =(base.options.rotations%2)?base.$image.height(): base.$image.width();
				base.originalHeight = (base.options.rotations%2)?base.$image.width(): base.$image.height();
			}
			if(base.originalWidth > 0) {
				var widthRatio = base.options.targetWidth / base.originalWidth;
				var heightRatio = base.options.targetHeight / base.originalHeight;
				base.minPercent = (widthRatio >= heightRatio) ? widthRatio : heightRatio;
                                var tempx=(base.options.rotations%2)?Math.round(base.originalHeight/2):Math.round(base.originalWidth/2);
				var tempy=(base.options.rotations%2)?Math.round(base.originalWidth/2):Math.round(base.originalHeight/2);
                                base.focalPoint = {'x': tempx, 'y': tempy};
				base.setZoom(base.minPercent);
				base.$image.fadeIn('fast'); //display image now that it has loaded
			}
		}
		function storeFocalPoint() {
			var x = (parseInt(base.$image.css('left'))*-1 + base.options.targetWidth/2) / base.workingPercent;
			var y = (parseInt(base.$image.css('top'))*-1 + base.options.targetHeight/2) / base.workingPercent;
			base.focalPoint = {'x': Math.round(x), 'y': Math.round(y)};
		}
		function focusOnCenter() {
                        if(base.options.rotations%2){
                            var left = fillContainer((Math.round((base.focalPoint.x*base.workingPercent) - base.options.targetWidth/2)*-1),(base.$image.height()-base.$image.width())/2, base.$image.height(), base.options.targetWidth);
                        var top = fillContainer((Math.round((base.focalPoint.y*base.workingPercent) - base.options.targetHeight/2)*-1),(base.$image.width()-base.$image.height())/2, base.$image.width(), base.options.targetHeight);

                        }else{
                        var left = fillContainer((Math.round((base.focalPoint.x*base.workingPercent) - base.options.targetWidth/2)*-1),0, base.$image.width(), base.options.targetWidth);
                        var top = fillContainer((Math.round((base.focalPoint.y*base.workingPercent) - base.options.targetHeight/2)*-1),0, base.$image.height(), base.options.targetHeight);

                        }
                    
//			var left = fillContainer((Math.round((base.focalPoint.x*base.workingPercent) - base.options.targetWidth/2)*-1), base.$image.width(), base.options.targetWidth);
//			var top = fillContainer((Math.round((base.focalPoint.y*base.workingPercent) - base.options.targetHeight/2)*-1), base.$image.height(), base.options.targetHeight);
//			var left = (base.$image.width()-base.options.targetWidth)/-2;
//                        var top = (base.$image.height()-base.options.targetHeight)/-2;
                        base.$image.css({'left': (left.toString()+'px'), 'top': (top.toString()+'px')})
			storeFocalPoint();
		}
		function updateResult() {
			base.result = {
				cropX: Math.floor(parseInt(base.$image.css('left'))/base.workingPercent*-1),
				cropY: Math.floor(parseInt(base.$image.css('top'))/base.workingPercent*-1),
				cropW: Math.round(base.options.targetWidth/base.workingPercent),
				cropH: Math.round(base.options.targetHeight/base.workingPercent),
				mustStretch: (base.minPercent > 1)
			};
			base.options.onChange.call(base.image, base.result);
		}
		function handeImageLoad() {
			initializeDimensions();
		}
		function handleMouseDown(event) {
			event.preventDefault(); //some browsers do image dragging themselves
			base.isDragging = true;
			base.dragMouseCoords = {x: event.pageX, y: event.pageY};
			base.dragImageCoords = {x: parseInt(base.$image.css('left')), y: parseInt(base.$image.css('top'))}
		}
		function handleMouseUp() {
			base.isDragging = false;
                        
		}
		function handleMouseMove(event) {
			if(base.isDragging) {
				var xDif = event.pageX - base.dragMouseCoords.x;
				var yDif = event.pageY - base.dragMouseCoords.y;
                                if(base.options.rotations%2){
                                    var newLeft = fillContainer((base.dragImageCoords.x + xDif),(base.$image.height()-base.$image.width())/2, base.$image.height(), base.options.targetWidth);
                                var newTop = fillContainer((base.dragImageCoords.y + yDif),(base.$image.width()-base.$image.height())/2, base.$image.width(), base.options.targetHeight);
                                
                                }else{
				var newLeft = fillContainer((base.dragImageCoords.x + xDif),0, base.$image.width(), base.options.targetWidth);
                                var newTop = fillContainer((base.dragImageCoords.y + yDif),0, base.$image.height(), base.options.targetHeight);
                                
				}
                                
                                base.$image.css({'left' : (newLeft.toString()+'px'), 'top' : (newTop.toString()+'px')});
				storeFocalPoint();
				updateResult();
			}
		}
		function handleMouseEnter() {
			if(base.options.smartControls) base.$frame.find('.jwc_controls').fadeIn('fast');
		}
		function handleMouseLeave() {
			if(base.options.smartControls) base.$frame.find('.jwc_controls').fadeOut('fast');
		}
		
		base.init();
	};
	
	$.jWindowCrop.defaultOptions = {
                rotations:0,
		targetWidth: 320,
		targetHeight: 180,
		zoomSteps: 10,
		loadingText: 'Loading...',
		smartControls: true,
		showControlsOnStart: true,
		onChange: function() {}
	};
	
	$.fn.jWindowCrop = function(options){
		return this.each(function(){
			(new $.jWindowCrop(this, options));
		});
	};
	
	$.fn.getjWindowCrop = function(){
		return this.data("jWindowCrop");
	};
})(jQuery);

