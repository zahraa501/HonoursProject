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
		//echo '<meta http-equiv="refresh" content="0; URL=http://localhost:8080/System/Login.php">';
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
		$user = trim($sent[0]);
		$remark = $sent[1];
		$info =  $sent[2];
		$info = explode("/",$info);		
		$course = $info[1];
		$test = $info[2]; 
		$dir = str_replace(" ","+",$info[3]);
		//Checks if StaffID is valid
		$Name = mysqli_query($con,"SELECT name, Type, LastLogin, LastLogout FROM staff WHERE StaffID='".$user."'");	
		$name = "";
		$Type = "";
		$login = "";
		$logout = "";
		//check if the user has the right to be marking this courses tests
		while($row = mysqli_fetch_array($Name))
		{
			$Type = $row['Type'];
			$name =  $row['name'];
			$login = $row['LastLogin'];
			$logout = $row['LastLogout'];
		}
		//fake username
		if(strlen($name)== 0)
		{
			
			//echo '<meta http-equiv="refresh" content="0; URL=http://localhost:8080/System/Login.php">';
		}
		//valid login/logout
		$loginsplit = explode(" ",$login);
		$logoutsplit = explode(" ",$logout);
		$date = date("Y-m-d h:i:sa");
		$datesplit = explode(" ",$date);
		//if the login date does not match the current date
		if($loginsplit[0] != $datesplit[0])
		{
			//echo '<meta http-equiv="refresh" content="0; URL=http://localhost:8080/System/Login.php">';
		}
		//logout has occured on this account
		if(strtotime($logout) > strtotime($login))
		{
			//echo '<meta http-equiv="refresh" content="0; URL=http://localhost:8080/System/Login.php">';
		}
		echo'<script> function loadpage(){$("body").show()}</script>';
	}
	mysqli_close($con);	
	?>
    <title>Demo</title>

    <!-- Core CSS - Include with every page -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Page-Level Plugin CSS - Panels and Wells -->

    <!-- SB Admin CSS - Include with every page -->
    <link href="css/sb-admin.css" rel="stylesheet">
	<script src="js/jquery.js"></script>
</head>

<body onload="loadpage()" style="display:none">

    <div id="wrapper">

        <nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <a class="navbar-brand" href="#"><i class="glyphicon glyphicon-pencil"></i>&nbsp;Editor</a>
				
            </div>
			<ul class="nav navbar-top-links navbar-right">
				<li><font color="grey"><?php echo $name;?>
				</font></li>
				 <li>
					<a  >
						<i class="fa fa-user fa-fw"></i> 
					</a>
                </li>
			</ul>
            <!-- /.navbar-top-links -->


            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div class="container"  style="width: 100%;">
          <br>
			<div class="row">
                <div class="col-lg-5">
				
					
					<div class="well">
					<?php
						echo '<img src="Files/'.$course.'/'.$test.'/'.$dir.'/page1.png" width="100%"/>';

					?>
					
                    </div>
					
					</div>
			
				<div class="col-lg-5">
					<form name="input" action="ViewFiles.php?q=<?php echo $user.'+'.$course.'/'.$test;?>" method="post">
					<label>Student Number:</label>
					<input type="text" class="form-control" name="studentNumber">
					<p>Please insert the student number found on the image.</p>
					<?php 
					$course = explode("CSC",$course);
					
					echo '<div class="form-group">
						<label for="disabledSelect">Course</label>
						<input class="form-control" id="disabledInput" type="text" value="CSC'.$course[1].'"placeholder="Disabled input" disabled="">
					</div>';
					echo '<div class="form-group">
						<label for="disabledSelect">Test</label>
						<input class="form-control" id="disabledInput" type="text"  value="'.str_replace("_", " ", $test).'"placeholder="Disabled input" disabled="">
					</div>';
					
					$mark = file_get_contents('Files/CSC'.$course[1].'/'.$test.'/'.$dir."/marks.txt");
					$mark = str_replace("This is the marks for: ".str_replace("/","",$info[3]),"",$mark);
					$content = file_get_contents('Files/CSC'.$course[1].'/'.$test.'/reformattedEndMarkers.txt');
					$content = explode("<split_marker>",$content);
					$total = explode(" ",$content[0]);
					echo '<div class="form-group">
						<label for="disabledSelect">Mark</label>
						<input class="form-control" id="disabledInput" type="text" value="'.$mark.'/'.str_replace("Question", "", $total[0]).'"placeholder="Disabled input" disabled="">
					</div>';
					echo '<input type="hidden" name="Remark" value="'.$remark.'">';
					echo '<input type="hidden" name="Course" value="CSC'.$course[1].'">';
					echo '<input type="hidden" name="Test" value="'.str_replace("_", " ", $test).'">';
					echo '<input type="hidden" name="Mark" value="'.str_replace(" ","",$mark).'">';
					echo '<input type="hidden" name="Name" value="'.str_replace(" ", "+", $dir).'">';
					?>
					
					<input type="submit" class="btn btn-outline btn-success btn-lg btn-block" name="Complete" value="Complete">
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
				
	    <!-- Core Scripts - Include with every page -->
		 <script src="js/bootstrap.min.js"></script>
		 <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    
    <!-- Page-Level Plugin Scripts - Panels and Wells -->

    <!-- SB Admin Scripts - Include with every page -->
    <script src="js/sb-admin.js"></script>
	

	
	</body>
</html>