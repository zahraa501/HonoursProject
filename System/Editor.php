<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php 
	$con=mysqli_connect("localhost:3306","root","Changmin88","honours_project");
	
	//checks if there is no StaffID
	if(isset($_REQUEST["q"])==0)
	{
		echo '<meta http-equiv="refresh" content="0; URL=http://localhost:8080/System/Login.php">';
	}
	else
	{
		if(isset($_POST['img_val'])!= 0)
		{
			//Get the base-64 string from data
			$filteredData=substr($_POST['img_val'], strpos($_POST['img_val'], ",")+1);
			 
			//Decode the string
			$unencodedData=base64_decode($filteredData);
			 
			//Save the image
			file_put_contents($_POST['folder'], $unencodedData);
		}
		
		$sent = explode("*", $_REQUEST["q"]);
		$user = $sent[0];
		$remark = $sent[1];
		$info =  $sent[2];
		$split = explode("/", $info);
		$course = $split[1];
		$test = $split[2];
		$name = str_replace(" ", "", $split[3])."+";
		$page = $split[4];
		$full = $course.'/'.$test.'/'.$name.'/';
		$pageNum = str_replace(".png","",$page);
		$pageNum = str_replace("page","",$pageNum);	
		//Checks if StaffID is valid
		$Name = mysqli_query($con,"SELECT name, Type, LastLogin, LastLogout FROM staff WHERE StaffID='".$user."'");	
		$TUTname = "";
		$Type = "";
		$login = "";
		$logout = "";
		//check if the user has the right to be marking this courses tests
		while($row = mysqli_fetch_array($Name))
		{
			$Type = $row['Type'];
			$TUTname =  $row['name'];
			$login = $row['LastLogin'];
			$logout = $row['LastLogout'];
		}
		//fake username
		if(strlen($name)== 0)
		{
			echo '<meta http-equiv="refresh" content="0; URL=http://localhost:8080/System/Login.php">';
		}
		//valid login/logout
		$loginsplit = explode(" ",$login);
		$logoutsplit = explode(" ",$logout);
		$date = date("Y-m-d h:i:sa");
		$datesplit = explode(" ",$date);
		//if the login date does not match the current date
		if($loginsplit[0] != $datesplit[0])
		{
			echo '<meta http-equiv="refresh" content="0; URL=http://localhost:8080/System/Login.php">';
		}
		//logout has occured on this account
		if(strtotime($logout) > strtotime($login))
		{
			echo '<meta http-equiv="refresh" content="0; URL=http://localhost:8080/System/Login.php">';
		}
		echo'<script> function loadpage(){$("body").show()}</script>';
	}
	mysqli_close($con);	
	?>
    <title></title>

    <!-- Core CSS - Include with every page -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Page-Level Plugin CSS - Panels and Wells -->

    <!-- SB Admin CSS - Include with every page 
	<script src="jquery.annotate.js"></script>-->
    <link href="css/sb-admin.css" rel="stylesheet">
	<script src="js/jquery.js"></script>
	<link rel="stylesheet" type="text/css" href="css/demo.css">
	
</head>

<body onload="tick()" style="width: 100%;">

    <div id="wrapper" onload="tick()" style="height: 100%;">

        <nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">
		 <div class="container-fluid">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
			
			 <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			  </button>
			  <a class="navbar-brand" href="#"><i class="glyphicon glyphicon-pencil"></i>&nbsp;Editor</a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" style="left-bottom: 10">
			
			
			  <div class="navbar-form navbar-right" >
					<input type="hidden" value="
					<?php 
			
					echo $_REQUEST["q"].'" name="directory"/>';
					echo '<font color="grey">'.$TUTname.'&nbsp;&nbsp;&nbsp;&nbsp;</font>';
					?> 
					<a href="ViewFiles.php?q=<?php echo $user.'+'.$course.'/'.$test;?>"  class="btn btn-default" data-toggle="tooltip" 
					data-placement="bottom" title="Save Script" onclick="saveMark()">Save</a>

					<input type="submit" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="Save Script" onclick="capture('<?php 
				echo 'SaveMark.php?q='.$user.'*'.$remark.'*/'.$full."page".($pageNum-1).".png";?>')" value="Complete">
			  </div>
			  <div class="navbar-form navbar-right" id="buttons">
					<button type="button" value="true " class="btn btn-default" id="tick" onclick="tick()"  data-toggle="tooltip" 
					data-placement="bottom" title="Tick Annotation"><span class="glyphicon glyphicon-ok"></span></button>
					<button type="button" value="false" class="btn btn-default" id="half" onclick="half()" data-toggle="tooltip" 
					data-placement="bottom" title="Half-tick Annotation"><span> <img src='Images/half-tick.png' width="15px" height="15px"/></span></button>
					<button type="button" value="false" class="btn btn-default"  data-toggle="tooltip" 
					data-placement="bottom" title="Cross Annotation" id="cross" onclick="cross()"><span class="glyphicon glyphicon-remove"></span></button>
					<button type="button" class="btn btn-default" onclick="undo()" data-toggle="tooltip" 
					data-placement="bottom" title="Undo"><span class="glyphicon glyphicon-repeat"></span></button>
					<button class="btn btn-default" data-toggle="tooltip" onclick="toggle_visibility()"
					data-placement="bottom" title="Comment"><span class="glyphicon glyphicon-comment"></span></button>
					<button class="btn btn-default" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-flag"></span></button>
					
					
			 </div>
			 
			
			 <div class="navbar-form navbar-right" >
			 
					<?php
					if($remark == "Yes")
					{
						if(file_exists('Files/'.$full."remark")== 0)
						{
						mkdir('Files/'.$full."remark/");
						//move files
						rename('Files/'.$full."marks.txt",'Files/'.$full."remark/marks.txt");
						rename('Files/'.$full."tickCoordinates.txt",'Files/'.$full."remark/tickCoordinates.txt");
						rename('Files/'.$full."tickType.txt",'Files/'.$full."remark/tickType.txt");
						//all save.png
						
						//change to extention name
						$directory = new DirectoryIterator('Files/'.$full);
						foreach($directory as $file ){
							//checks is the file is an image	
							if(substr($file,0,4) == "save")
							{
								rename('Files/'.$full.$file,'Files/'.$full."remark/".$file);
							}
						}
						}
					}
					if(file_exists('Files/'.$full."marks.txt")== 0)
					{
						$marksFile = fopen('Files/'.$full.'marks.txt', "w");
						file_put_contents('Files/'.$full.'marks.txt', "This is the marks for: ".$split[3]."\n0");
						fclose($marksFile);
						$mark = 0;
					}
					if(file_exists('Files/'.$full."tickCoordinates.txt")== 0)
					{
						
						$myfile = fopen('Files/'.$full.'tickCoordinates.txt', "w");
						fclose($myfile); 
					}
					if(file_exists('Files/'.$full."tickType.txt")== 0)
					{
						//create file that stores tick types
						$myOtherfile = fopen('Files/'.$full.'tickType.txt', "w");
						fclose($myOtherfile); 
					
					}
					$mark = file_get_contents('Files/'.$full."marks.txt");
					$mark = str_replace("This is the marks for: ".str_replace("/","",$split[3]),"",$mark);
					echo '<button type="button" id="mark" class="btn btn-success disabled" value="'.$mark.'">';
					echo "Mark: ".$mark;
					//echo $_REQUEST["q"];
					echo '<input type="hidden" id="totalmark" value="'.$mark.'"/>';
					echo '<input type="hidden" id="user" value="'.$user.'"/>';
					?>
					</button>
			 </div>
			</div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
            <!-- /.navbar-top-links -->

           
            <!-- /.navbar-static-side -->
        </nav>

        <div class="container" style="width: 100%;">
		<br>
		<div class="row">
                <div class="col-lg-3">
                    <div class="chat-panel panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-comments fa-fw"></i>
							Memorandum
						</div>
					
						<div class="panel-body" style="height: 460px">
                            <ul class="chat">
							<?php
								$content = file_get_contents('Files/'.$course.'/'.$test.'/reformattedEndMarkers.txt');
								$content = explode("<split_marker>",$content);
								for($i =1; $i<sizeOf($content);$i = $i +2)
								{
                                echo '<li class="left clearfix">
                                    <span class="chat-img pull-left">
                                        <button type="button" class="btn btn-info btn-circle btn-lg disabled"><i class="glyphicon glyphicon-question-sign"></i></button>
                                    </span>
                                    <div class="chat-body clearfix">
                                        <div class="header">
                                            <strong class="primary-font">Question</strong> 
                                        </div>
                                        <p>
                                            '.$content[$i].'
                                        </p>
                                    </div>
                                </li>';
								echo '<li class="right clearfix" style="background-color:#F0F0F0;">
                                    <span class="chat-img pull-right">
                                        <button type="button" class="btn btn-success btn-circle btn-lg disabled"><i class="fa fa-check"></i></button>
                                    </span>
                                    <div class="chat-body clearfix" >
                                        <div class="header">
                                            
                                            <strong class="pull-right primary-font">Answer</strong>
                                        </div>
										<br>
                                            '.$content[$i+1].'
                                        
                                    </div>
                                </li>';
								}
							?>
							</ul>
						</div>
					</div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-6 -->
                <div class="col-lg-9">
                    <div>
					<!-- /.panel-heading -->
				<div class="panel-body" style="height: 460px">
						
				<div id="target" width="100%" class="row">
				<div class="col-lg-9">
				<div id="nutmeg"  onclick="save()">
				<form method="POST" enctype="multipart/form-data" id="myForm">
				<?php
					//number of files
					$fileCount = 0;
					//change to extention name
					$directory = new DirectoryIterator('Files/'.$full);
					foreach($directory as $file ){
						//checks is the file is an image	
						if(strpos($file, ".png")>0)
						{
							$fileCount = $fileCount +1;
						}
					}
					
					
					echo '<input type="hidden" id="page" value="'.$pageNum.'"/>';
					echo '<input type="hidden" id="dir" value="'.$full.'"/>';
					echo '<img src="Files/'.$full.$page.'" width="95%"/>'; //width="400px"/>
					
					
					$info = file_get_contents('Files/'.$full."tickCoordinates.txt");
					$tickInfo = file_get_contents('Files/'.$full."tickType.txt");
					$info = explode("*", $info);
					$tickInfo = explode("*", $tickInfo);
					$count = 0;
					foreach($info as $line)
					{
						
						$attribute = explode("*",$line);
						$moreInfo = explode(" ", $tickInfo[$count]);
							
						
						if($count < sizeOf($info)-1)
						{
							//create x and y variables of tick
							$coordinates = explode(" ", $attribute[0]);
							$x = $coordinates[0];
							$y = $coordinates[1];
							//echo $x.' : '.$y.'<br>';
							
							$count = $count +1;
							
							//tick and page information
							$tick = $moreInfo[0];
							$pageTick = $moreInfo[1];
							//echo $tick.' : '.$pageTick.'<br>';
							//echo $tick." ".$x." ".$y."<br>";
							if($pageNum == $pageTick)
							{
								 // echo "there are ticks for this page";
								
								if(strpos($tick,"tick") || $tick ==="tick")
								{ 
									//echo "true";
									echo '<span class="black circle note" style="left:'.$x.';top: '.$y.'; position: absolute;"></span>';
								}
								else if(strpos($tick,"half") || $tick ==="half")
								{
									//echo "false";
									echo '<span class="black circle noteHalf" style="left:'.$x.';top: '.$y.'; position: absolute;"></span>';
								}
								else if(strpos($tick,"cross") || $tick ==="cross")
								{
									//echo "false";
									echo '<span class="black circle noteCross" style="left:'.$x.';top: '.$y.'; position: absolute;"></span>';
								}
								//echo $tick." ".$x." ".$y."<br>";
							}
						}
					}
					
				?>				
				
				
				</div>
				</div>
				<div class="col-lg-3" width="100%">
				<br><br>
				             <div  class="chat-panel panel panel-default" id="comment" style="display:none" >
                        <!-- /.panel-heading -->
                        <div class="panel-body" >
                            <ul class="chat"> 
                                <li class="left clearfix">
								<div class="header">
									<strong class="primary-font">Jack Sparrow</strong> 
								</div>
								<p>
									Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare dolor, quis ullamcorper ligula sodales.
								</p>
                                    
                                </li>
                                <li class="left clearfix">
								<div class="header">
									<strong class="primary-font">Jack Sparrow</strong> 
								</div>
								<p>
									Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare dolor, quis ullamcorper ligula sodales.
								</p>
                                    
                                </li>
                               
                            </ul>
                        </div>
                        <!-- /.panel-body -->
                        <div id="footer" class="panel-footer">
                            <div class="input-group">
                                <input id="btn-input" type="text" class="form-control input-sm" placeholder="Type comment here.">
                                <span class="input-group-btn">
                                    <button class="btn btn-warning btn-sm" id="btn-chat">
                                        Send
                                    </button>
                                </span>
                            </div>
                        </div>
                        <!-- /.panel-footer-->
                    </div>
				</div>
				<input type="hidden" name="img_val" id="img_val" value="" />
				<input type="hidden" name="folder" id="folder" value="<?php echo 'Files/'.$full.'save'.$pageNum.'.png';?>" />
                </form>
				</div>

				</div>
				</div>
				</div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-6 -->
            </div>
           <div class="footer navbar-fixed-bottom" style="background-color:#F0F0F0 ;padding: 8px 0px; border-top-style: solid; border-top-width: 1px;border-top-color:#e7e7e7;">
		   <div class="container">
		   <div class="text-center">
		   <div class="btn-group">
		   
			   <input type="submit" class="btn btn-default" onclick="capture('<?php 
				echo 'Editor.php?q='.$user.'*'.$remark.'*/'.$full."page".($pageNum-1).".png";
			   ?>')" value="Previous" <?php if($pageNum-1 == 1){echo "disabled";}?>>
			   
			   <input type="submit" class="btn btn-default" onclick="capture('<?php 
				echo 'Editor.php?q='.$user.'*'.$remark.'*/'.$full."page".($pageNum+1).".png";
			   ?>')" value="Next" <?php if($pageNum+1 == 7){echo "disabled";} //change upper bound?>> 
				
			</div>
			 </div>
		   </div>
		   </div>
	
		
    </div>
	
			<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-exclamation-sign Report Script"></span> Report Script</h4>
			  </div>
			  <div class="modal-body">
				Please state the reason for reporting this script:
				<textarea id="flagComment" class="form-control" rows="5"></textarea>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-info btn-circle btn-lg" onclick="flag()" data-dismiss="modal"><i class="glyphicon glyphicon-envelope"></i></button>
				<button type="button" class="btn btn-danger btn-circle btn-lg" data-dismiss="modal"><i class="fa fa-times"></i></button>
			  </div>
			</div>
		  </div>
		</div>
				
	    <!-- Core Scripts - Include with every page -->
		 <script src="js/bootstrap.min.js"></script>
		 <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
		<script type="text/javascript" src="js/html2canvas.js"></script>
		<script type="text/javascript" src="js/jquery.plugin.html2canvas.js"></script>
    <!-- Page-Level Plugin Scripts - Panels and Wells -->

    <!-- SB Admin Scripts - Include with every page -->
    <script src="js/sb-admin.js"></script>
	
	<script>
	$(document).ready(function(){
	  function blackNote() {
			if(document.getElementById("tick").value== "true")
			{
				
				document.getElementById("mark").value = parseFloat(document.getElementById("mark").value) +1;
				document.getElementById("mark").innerHTML = "Mark: "+document.getElementById("mark").value;
				//saveMark();
				//mark plus 1
			return $(document.createElement('span')).
				addClass('black circle note')
			}
			else if (document.getElementById("half").value== "true")
			{
				document.getElementById("mark").value = parseFloat(document.getElementById("mark").value) +0.5;
				document.getElementById("mark").innerHTML = "Mark: "+document.getElementById("mark").value;
				//updateMark();
				
				//mark plus 1/2
				return $(document.createElement('span')).
				addClass('black circle noteHalf')
			}
			else if (document.getElementById("cross").value== "true")
			{
			
				return $(document.createElement('span')).
				addClass('black circle noteCross')
			}
		}
		
		$('#nutmeg').annotatableImage(blackNote);
		
		$('#numberedNutmeg img').load(function(){
			$('#numberedNutmeg').addAnnotations(function(annotation){
				if(document.getElementById("tick").value== "true")
				{
				
				return $(document.createElement('span')).
				addClass('black circle note').html(annotation.position);}
				else if(document.getElementById("cross").value== "true")
				{
				
				return $(document.createElement('span')).
					addClass('black circle noteCross').html(annotation.position);}
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
			else if(document.getElementById("cross").value== "true")
				{
			$('#smallNutmeg').addAnnotations(blackNote, $('#nutmeg span.noteCross').seralizeAnnotations());
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
				$.each($('#nutmeg span.noteCross').seralizeAnnotations(), function(){
				
				$('#serializedOutput ul').append($(document.createElement('li')).html('CROSS: <strong>x:</strong> ' + this.x + ' <strong>y:</strong> ' + this.y + ' <strong>response_time:</strong> ' + this.response_time + 'ms'));
			});
			if(document.getElementById("tick").value== "true")
			{
				position = document.getElementById("dir").value+'tick '+page;
			}
			else if(document.getElementById("half").value== "true")
			{
				position = document.getElementById("dir").value+'half '+page;
			}
			else if(document.getElementById("cross").value== "true")
			{
				position = document.getElementById("dir").value+'cross '+page;
			}

		if(document.getElementById("tick").value== "true"||document.getElementById("half").value== "true" || document.getElementById("cross").value== "true")
		{		
		 var xmlhttp=new XMLHttpRequest();
		  xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			  //document.getElementById("mark").innerHTML=xmlhttp.responseText;
			}
		  }
		  xmlhttp.open("GET","writeToOtherFile.php?q="+position,true);
		  xmlhttp.send();
		  }
		  saveMark();
	}
	function undo() {
		//information that is sent
		str= document.getElementById("dir").value+"page"+document.getElementById("page").value+".png";
		var xmlhttp=new XMLHttpRequest();
		xmlhttp.onreadystatechange=function() {
		var type = xmlhttp.responseText;
		//retrieves current mark and makes it a float
		var mark = parseFloat(document.getElementById("mark").value);
		//splits information
		var coordinates = type.split(/[ ,]+/);
		//locates all ticks
		$("span").each(function(index, elem){
		//compares coordinates of tick
			if( $.trim($(this).css("left")) == coordinates[0] && $.trim($(this).css("top")) == coordinates[1])
			{ 
				//deletes tick
				this.remove();
			}
		});
		//changes mark
		if(coordinates[2] == "tick")
		{
			document.getElementById("mark").value = mark -0.5;
		}
		else if(coordinates[2] == "half")
		{
			mark = mark -0.25;	
		}
		//displays mark
		document.getElementById("mark").innerHTML="Mark: "+document.getElementById("mark").value;
		//saves mark
		saveMark();
	  }
	  
	  xmlhttp.open("GET","undo.php?q="+str,true);
	  xmlhttp.send(); 
	}
	function saveMark() {
	  var info = document.getElementById("dir").value+document.getElementById("mark").value;
	  var xmlhttp=new XMLHttpRequest();
	  xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		
		
		 //document.getElementById("mark").innerHTML= info;
		  
		}
	  }
	  xmlhttp.open("GET","Marks.php?q="+info,true);
	  xmlhttp.send();
	}
	function toggle_visibility() 
    {
        var e = document.getElementById("comment");
        if ( e.style.display == 'block' )
            e.style.display = 'none';
        else
            e.style.display = 'block';
    }
	function capture(value)
	{
		document.getElementById('myForm').action = value;
		$('#target').html2canvas({
        onrendered: function (canvas) {
            //Set hidden field's value to image data (base-64 string)
            $('#img_val').val(canvas.toDataURL("image/png"));
            //Submit the form manually
            document.getElementById("myForm").submit();
        }
    });
	}
	function flag()
	{
		//alert(document.getElementById("flagComment").value);
		var info = document.getElementById("dir").value+'/'+document.getElementById("user").value+'/'+document.getElementById("flagComment").value;
		 var xmlhttp=new XMLHttpRequest();
		  xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			 //document.getElementById("mark").innerHTML= info;
			  
			}
		  }
		  xmlhttp.open("GET","SaveFlag.php?q="+info,true);
		  xmlhttp.send();
		  document.getElementById("flagComment").value = "";
	}
	function tick()
	{
	  document.getElementById("tick").value = "true";
	  document.getElementById("half").value = "false";
	  document.getElementById("tick").className = "btn btn-default active"
	  document.getElementById("half").className = "btn btn-default"
	  document.getElementById("cross").value = "false";
	  document.getElementById("cross").className = "btn btn-default"
	}
	function half()
	{

	  document.getElementById("half").value = "true";
	  document.getElementById("tick").value = "false";
	  document.getElementById("half").className = "btn btn-default active"
	  document.getElementById("tick").className = "btn btn-default"
	  document.getElementById("cross").value = "false";
	  document.getElementById("cross").className = "btn btn-default"
	}
	function cross()
	{

	  document.getElementById("half").value = "false";
	  document.getElementById("tick").value = "false";
	  document.getElementById("half").className = "btn btn-default"
	  document.getElementById("tick").className = "btn btn-default"
	  document.getElementById("cross").value = "true";
	  document.getElementById("cross").className = "btn btn-default active"
	}
	$(function() 
	{ 
		//button tooltips
		$("[data-toggle='tooltip']").tooltip(); 
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
		$.fn.coordinates=function(){
				position = $(this).css('left')+" "+$(this).css('top')+"*";
				var xmlhttp=new XMLHttpRequest();
				  xmlhttp.onreadystatechange=function() {
					if (xmlhttp.readyState==4 && xmlhttp.status==200) {
					
					}
				  }
				  xmlhttp.open("GET","writeToFile.php?q="+document.getElementById("dir").value+position,true);
				  xmlhttp.send();
				  return{x:parseInt($(this).css('left').replace('px','')),y:parseInt($(this).css('top').replace('px',''))};};})(jQuery);	
	</script>
	</body>
</html>