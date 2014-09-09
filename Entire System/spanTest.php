<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>css demo</title>
  <script src="js/jquery.js"></script>
      <!-- Core CSS - Include with every page -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Page-Level Plugin CSS - Panels and Wells -->

    <!-- SB Admin CSS - Include with every page 
	<script src="jquery.annotate.js"></script>-->
    <link href="css/sb-admin.css" rel="stylesheet">
   <link rel="stylesheet" type="text/css" href="css/demo.css">
</head>
<body>
</div>
<p id="result">&nbsp;</p>
<!--<div id="box1" style="width: 50px;color: yellow;background-color: blue;">1</div>
<div id="box2" style="width: 80px;color: rgb(255, 255, 255);background-color: rgb(15, 99, 30);">2</div>
<div id="box3" style="width: 40px;color: #fcc;background-color: #123456;">3</div>
<div id="box4" style="width: 70px;background-color: #f11;">4</div>-->
 <div id="nutmeg" onclick="save()">
 <img src="backup/hyungjun.jpg"/>
 </div>
<script>
/*$( "div" ).click(function() {
  var html = [ "The clicked div has the following styles:" ];
 
  var styleProps = $( this ).css([
    "width", "height", "color", "background-color"
  ]);
  $.each( styleProps, function( prop, value ) {
    html.push( prop + ": " + value );
  });
 
  $( "#result" ).html( html.join( "<br>" ) );
});*/
$(document).ready(function(){
	  function blackNote() {
		
			return $(document.createElement('span')).
				addClass('black circle note')
			}
			
		}
		
		$('#nutmeg').annotatableImage(blackNote);
		
		$('#numberedNutmeg img').load(function(){
			$('#numberedNutmeg').addAnnotations(function(annotation){
				
				
				return $(document.createElement('span')).
					addClass('black circle note').html(annotation.position);}
			
			},[
					{x: 0.3875, y: 0.3246, position: 4}, 
					{x: .57, y: .329, position: 2}
				]
			);
			
		});
		
		$('#labeledNutmeg').annotatableImage(function(annotation){
			return $(document.createElement('span')).
				addClass('set-label');
		}, {xPosition: 'left'});

		$('#doItHansel').click(function(event){
			event.preventDefault();
				
			$('#smallNutmeg').addAnnotations(blackNote, $('#nutmeg span.note').seralizeAnnotations());
			}
			
		});

	});

	(function($){$.fn.annotatableImage=function(annotationCallback,options){var defaults={xPosition:'middle',yPosition:'middle'};
		var options=$.extend(defaults,options);
		var annotations=[];var image=$('img',this)[0];var date=new Date();var startTime=date.getTime();
		this.mousedown(function(event){if(event.target==image){event.preventDefault();
		var element=annotationCallback();annotations.push(element);
		$(this).append(element);element.positionAtEvent(event,options.xPosition,options.yPosition);
		var date=new Date();element.data('responseTime',date.getTime()- startTime);}});};
		$.fn.addAnnotations=function(annotationCallback,annotations,options){var container=this;var containerHeight=$(container).height();
		var defaults={xPosition:'middle',yPosition:'middle',height:containerHeight};
		var options=$.extend(defaults,options);$.each(annotations,function(){var element=annotationCallback(this);
		element.css({position:'absolute'});$(container).append(element);var left=(this.x*$(container).width())-($(element).xOffset(options.xPosition));
		var top=(this.y*options.height)-($(element).yOffset(options.yPosition));
		if(this.width&&this.height){var width=(this.width*$(container).width());
		var height=(this.height*$(container).height());element.css({width:width+'px',height:height+'px'});}
		element.css({left:left+'px',top:top+'px'});
		if(top>containerHeight){element.hide();}});};
		$.fn.positionAtEvent=function(event,xPosition,yPosition){var container=$(this).parent('div');
		$(this).css('left',event.pageX- container.offset().left-($(this).xOffset(xPosition))+'px');
		$(this).css('top',event.pageY- container.offset().top-($(this).yOffset(yPosition))+'px');
		$(this).css('position','absolute');};
		$.fn.seralizeAnnotations=function(xPosition,yPosition){var annotations=[];this.each(function(){annotations.push({x:$(this).relativeX(xPosition),y:$(this).relativeY(yPosition),response_time:$(this).data('responseTime')});});return annotations;};
		$.fn.relativeX=function(xPosition){var left=$(this).coordinates().x+($(this).xOffset(xPosition));var width=$(this).parent().width();return left/width;}
		$.fn.relativeY=function(yPosition){var top=$(this).coordinates().y+($(this).yOffset(yPosition));var height=$(this).parent().height();return top/height;}
		$.fn.relativeWidth=function(){return $(this).width()/$(this).parent().width();}
		$.fn.relativeHeight=function(){return $(this).height()/$(this).parent().height();}
		$.fn.xOffset=function(xPosition){switch(xPosition){case'left':return 0;break;case'right':return $(this).width();break;default:return $(this).width()/2;}};
		$.fn.yOffset=function(yPosition){switch(yPosition){case'top':return 0;break;case'bottom':return $(this).height();break;default:return $(this).height()/2;}};
		$.fn.coordinates=function(){return{x:parseInt($(this).css('left').replace('px','')),y:parseInt($(this).css('top').replace('px',''))};};})(jQuery);
</script>
 
</body>
</html>