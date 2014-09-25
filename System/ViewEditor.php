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
		$info =  $sent[1];
		$split = explode("/", $info);
		$course = $split[1];
		$test = $split[2];
		$name = str_replace(" ", "", $split[3])."+";
		$page = $split[4];
		$full = $course.'/'.$test.'/'.$name.'/';
		$pageNum = str_replace(".png","",$page);
		$pageNum = str_replace("save","",$pageNum);	
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

<body style="width: 100%;">

    <div id="wrapper"" style="height: 100%;">

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
					<a href="Editor.php?q=<?php echo $user.'*Yes*/'.$course.'/'.$test.'/'.$name.'/page2.png';?>"  class="btn btn-default" data-toggle="tooltip" 
					data-placement="bottom" title="Save Script" onclick="saveMark()" <?php if(file_exists('Files/'.$full."remark")!= 0){ echo "disabled";}?>>Remark</a>
					<a href="ViewFiles.php?q=<?php echo $user.'+'.$course.'/'.$test;?>"  class="btn btn-default" data-toggle="tooltip" 
					data-placement="bottom" title="Save Script" onclick="saveMark()">Close</a>

				</div>
			  <div class="navbar-form navbar-right" id="buttons">
					<button type="button" value="true " class="btn btn-default" id="in" onclick="zoomIN()"  data-toggle="tooltip" 
					data-placement="bottom" title="Zoom In"><span class="glyphicon glyphicon-zoom-in"></span></button>
					<button type="button" value="true " class="btn btn-default" id="out" onclick="zoomOUT()"  data-toggle="tooltip" 
					data-placement="bottom" title="Zoom Out"><span class="glyphicon glyphicon-zoom-out"></span></button>
					<button class="btn btn-default" data-toggle="tooltip" 
					data-placement="bottom" title="Comment"><span class="glyphicon glyphicon-comment"></span></button>
					<button class="btn btn-default" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-flag"></span></button>
					
					
			 </div>
			</div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
            <!-- /.navbar-top-links -->

           
            <!-- /.navbar-static-side -->
        </nav>

        <div class="container" style="width: 100%;">
		<br>
		<div class="row">
			<div class="text-center" width="839px" height="1128px">
			   <img id="image" src="Files<?php echo str_replace(" ","+",$sent[1])?>"/>
			</div>
        </div>
                <!-- /.col-lg-6 -->
            </div>
        <div class="footer navbar-fixed-bottom" style="background-color:#F0F0F0; border-top-style: solid; border-top-width: 1px;border-top-color:#e7e7e7;">
		    <div class="container">
		    <div class="text-center">
		    <div id="btn-group">
		   
			   <?php
			   //number of files
				$fileCount = 0;
				//change to extention name
				$directory = new DirectoryIterator('Files/'.$full);
				foreach($directory as $file ){
				
					//checks is the file is an image	
					if(substr($file,0,4) == "save")
					{
						$fileCount = $fileCount +1;
					}
				}
				
				
				//start of navigation
				echo '<ul class="pagination pagination-lg">';
				//back button
				if($pageNum >2)
				{
					echo '<li><a onclick="changePage(\'Files/'.$full.'save'.($pageNum-1).'.png\')" >«</a></li>';
				}
				else
				{
					echo '<li class="disabled"><a href="#">«</a></li>';
				}
				//numbered buttons
				for($num = 2; $num <$fileCount+2; $num++)
				{
					//button that page is on
					if(strcmp($pageNum,$num) == 0)
					{
						echo '<li class="active"><a onclick="changePage(\'Files/'.$full.'save'.$num.'.png\')">'.($num-1).'<span class="sr-only">(current)</span></a></li>';
					}
					else
					{
						echo '<li><a onclick="changePage(\'Files/'.$full.'save'.$num.'.png\')" class="active">'.($num-1).'</a></li>';
					}
				}
				//next button
				if($pageNum <= $fileCount)
				{
					echo '<li><a onclick="changePage(\'Files/'.$full.'save'.($pageNum+1).'.png\')">»</a></li>';
				}
				else
				{
					echo '<li class="disabled"><a href="#">»</a></li>';
				}
				echo '</ul>';
			  ?>
				
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
	function zoomIN()
	{
	  document.getElementById("in").value = "true";
	  document.getElementById("out").value = "false";
	  document.getElementById("in").className = "btn btn-default active"
	  document.getElementById("out").className = "btn btn-default"
	  //change 
	}
	function zoomOUT()
	{

	  document.getElementById("out").value = "true";
	  document.getElementById("in").value = "false";
	  document.getElementById("out").className = "btn btn-default active"
	  document.getElementById("in").className = "btn btn-default"
	  //change
	}
	function changePage(page)
	{
		//alert(page);
		document.getElementById("image").src = page;
		sections = page.split("/");
		pageNum = sections[4].replace("save", "");
		pageNum = pageNum.replace(".png", "");
		
		var xmlhttp=new XMLHttpRequest();
		  xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			 document.getElementById("btn-group").innerHTML= xmlhttp.responseText;
			 // alert(xmlhttp.responseText);
			}
		  }
		  xmlhttp.open("GET","ChangeQuestion.php?q="+"<?php echo $full;?>"+pageNum,true);
		  xmlhttp.send();
		  
	}
	$(function() 
	{ 
		//button tooltips
		$("[data-toggle='tooltip']").tooltip(); 
	});
	
	</script>
	</body>
</html>