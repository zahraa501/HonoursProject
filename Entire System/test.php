<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Demo</title>

    <!-- Core CSS - Include with every page -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Page-Level Plugin CSS - Panels and Wells -->

    <!-- SB Admin CSS - Include with every page -->
    <link href="css/sb-admin.css" rel="stylesheet">
	<script src="js/jquery.js"></script>
	

</head>

<body>

    <div id="wrapper">

        <nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <a class="navbar-brand" href="index.html">Demo</a>
				  <div class="navbar-form navbar-right" id="buttons">
					<button type="button" value="true " class="btn btn-default" id="tick" onclick="tick()"  data-toggle="tooltip" 
					data-placement="bottom" title="Tick Annotation"><span class="glyphicon glyphicon-ok"></span></button>
					<button type="button" value="false" class="btn btn-default" id="half" onclick="half()" data-toggle="tooltip" 
					data-placement="bottom" title="Half-tick Annotation"><span> <img src='Images/half-tick.png' width="15px" height="15px"/></span></button>
					<button type="button" class="btn btn-default" onclick="undo()" data-toggle="tooltip" 
					data-placement="bottom" title="Undo"><span class="glyphicon glyphicon-repeat"></span></button>
					<button class="btn btn-default" data-toggle="modal" data-target="#myModal">
					  <span class="glyphicon glyphicon-flag"></span>
					</button>
			 </div>
				
            </div>
            <!-- /.navbar-top-links -->

            <div class="navbar-default navbar-static-side" role="navigation">
                <div class="sidebar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li>
                            <a href="index.html"><i class="fa fa-dashboard fa-fw"></i> Home</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-edit fa-fw"></i> Scripts<span class="fa arrow"></a>
							<ul class="nav nav-second-level">
                                <li>
                                    <a href="#">View Scripts</a>
                                </li>
                                <li>
                                    <a href="AddCourse.php">Add a Course</a>
                                </li>
                                <li>
                                    <a href="AddTest.php">Add a Test</a>
                                </li>
                                <li>
                                    <a href="AddScript.php">Add a Script</a>
                                </li>
                            </ul>
                        </li>
						<li>
                            <a href="tables.html"><i class="fa fa-table fa-fw"></i> Tables</a>
                        </li>
						<li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Dashboard</span></a>
                        </li>
                    </ul>
                    <!-- /#side-menu -->
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div id="value">
			</div>
				<!--<div class="btn-toolbar" role="toolbar">
				  <div class="btn-group">
					<button type="button" class="btn btn-default"><span class="glyphicon glyphicon-ok"></span></button>
					<button type="button" class="btn btn-default"><span> <img src='half-tick.png' width="15px" height="15px"/></span></button>
					<button type="button" class="btn btn-default"><span class="glyphicon glyphicon-repeat"></span></button>
					<button type="button" class="btn btn-default"><span class="glyphicon glyphicon-flag"></span></button>
				  </div>
				</div>-->
                
		</div>
	</div>
	    <!-- Core Scripts - Include with every page -->
		 <script src="js/bootstrap.min.js"></script>
		 <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    
    <!-- Page-Level Plugin Scripts - Panels and Wells -->

    <!-- SB Admin Scripts - Include with every page -->
    <script src="js/sb-admin.js"></script>
	
	<script>
	var count=  parseInt(document.getElementById("totalmark").value);
	
	$(document).ready(function(){
	  function blackNote() {
			if(document.getElementById("tick").value== "true")
			{
				count = count +1;
				document.getElementById("mark").innerHTML = "Mark: "+count;
				//mark plus 1
			return $(document.createElement('span')).
				addClass('black circle note')
			}
			else if (document.getElementById("half").value== "true")
			{
				count = count +0.5;
				document.getElementById("mark").innerHTML = "Mark: "+count;
				//mark plus 1/2
				return $(document.createElement('span')).
				addClass('black circle noteHalf')
			}
		}
		
		$('#nutmeg').annotatableImage(blackNote);
		
		$('#numberedNutmeg img').load(function(){
			$('#numberedNutmeg').addAnnotations(function(annotation){
				if(document.getElementById("tick").value== "true")
				{
				
				return $(document.createElement('span')).
					addClass('black circle note').html(annotation.position);}
				else
				{
					return $(document.createElement('span')).
					addClass('black circle noteHalf').html(annotation.position);
				}
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
				if(document.getElementById("tick").value== "true")
				{
			$('#smallNutmeg').addAnnotations(blackNote, $('#nutmeg span.note').seralizeAnnotations());
			}
			else
			{
				$('#smallNutmeg').addAnnotations(blackNote, $('#nutmeg span.noteHalf').seralizeAnnotations());
			}
		});
	/*$("#nutmeg span.noteHalf").click(function(){
	$("span").remove();
	//alert(document.getElementById("#nutmeg span.noteHalf"));});*/
	});
	function save()
	{
		var page = document.getElementById("page").value;
		$('#serializedOutput ul').empty();
			var position; 
			$.each($('#nutmeg span.note').seralizeAnnotations(), function(){
				
				$('#serializedOutput ul').append($(document.createElement('li')).html('<strong>x:</strong> ' + this.x + ' <strong>y:</strong> ' + this.y + ' <strong>response_time:</strong> ' + this.response_time + 'ms'));
			});
			
				
				$.each($('#nutmeg span.noteHalf').seralizeAnnotations(), function(){
				
				$('#serializedOutput ul').append($(document.createElement('li')).html('HALF: <strong>x:</strong> ' + this.x + ' <strong>y:</strong> ' + this.y + ' <strong>response_time:</strong> ' + this.response_time + 'ms'));
			});
			if(document.getElementById("tick").value== "true")
			{
				position = 'tick '+page;
			}
			else if(document.getElementById("half").value== "true")
			{
				position = 'half '+page;
			}
		if(document.getElementById("tick").value== "true"||document.getElementById("half").value== "true")
		{		
		 var xmlhttp=new XMLHttpRequest();
		  xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			  document.getElementById("undo").innerHTML=xmlhttp.responseText;
			}
		  }
		  xmlhttp.open("GET","writeToOtherFile.php?q="+position,true);
		  xmlhttp.send();
		  }
	}
	function checkFiles(str) {
	  str= "test";
	  
	  var xmlhttp=new XMLHttpRequest();
	  xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		  //document.getElementById("mark").innerHTML=xmlhttp.responseText;
		}
	  }
	  xmlhttp.open("GET","fileCreation.php?q="+str,true);
	  xmlhttp.send();
	 
	}
	function undo() {
	str= document.getElementById("dir").value+"page"+document.getElementById("page").value+".png";
	  if (str.length==0) {
		document.getElementById("nutmeg").innerHTML="";
		return;
	  }
	  var xmlhttp=new XMLHttpRequest();
	  xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		  document.getElementById("nutmeg").innerHTML=xmlhttp.responseText;
		}
	  }
	  xmlhttp.open("GET","undo.php?q="+str,true);
	  xmlhttp.send();
	  //updateMark()
	  window.location.reload();
	}
	/*function question(str) {
	  if (str.length==0) {
		document.getElementById("nutmeg").innerHTML="";
		return;
	  }
	  var xmlhttp=new XMLHttpRequest();
	  xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		  document.getElementById("nutmeg").innerHTML=xmlhttp.responseText;
		}
	  }
	  xmlhttp.open("GET","ChangeQuestion.php?q="+str,true);
	  xmlhttp.send();
	  questionNavigation(str);
	}*/
	function updateMark() {
	  
	  var xmlhttp=new XMLHttpRequest();
	  xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		  document.getElementById("mark").innerHTML=xmlhttp.responseText;
		}
	  }
	  xmlhttp.open("GET","Marks.php?q="+count,true);
	  xmlhttp.send();
	}
		function tick()
	{
	   
	   
	  /*var xmlhttp=new XMLHttpRequest();
	  xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			
		  document.getElementById("buttons").innerHTML=xmlhttp.responseText;
		}
	  }
	  xmlhttp.open("GET","buttonChanges.php?q=tick",true);
	  xmlhttp.send();*/
	  document.getElementById("tick").value = "true";
	  document.getElementById("half").value = "false";
	  document.getElementById("tick").className = "btn btn-default active"
	  document.getElementById("half").className = "btn btn-default"
	  document.getElementById("values").innerHTML= document.getElementById("tick").value;
	}
	function half()
	{
	   

		/*var xmlhttp=new XMLHttpRequest();
		xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			
		  document.getElementById("buttons").innerHTML=xmlhttp.responseText;
		}
	  }
	  xmlhttp.open("GET","buttonChanges.php?q=half",true);
	  xmlhttp.send();*/
	  document.getElementById("half").className = "btn btn-default active"
	  document.getElementById("tick").className = "btn btn-default"
	  document.getElementById("half").value = "true";
	  document.getElementById("tick").value = "false";	
	  document.getElementById("values").innerHTML= document.getElementById("tick").value;
	}	
	</script>

	
	</body>
</html>