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
		$sent = explode(" ", $_REQUEST["q"]); 
		$user = $sent[0];
		$split = explode("/", $sent[1]);
		//Checks if StaffID is valid
		$Name = mysqli_query($con,"SELECT name, Type, LastLogin, LastLogout FROM staff WHERE StaffID='".$user."'");	
		$name = "";
		$Type = "";
		$login = "";
		$logout = "";
		
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
		$course = $split[0];
		$show = 0;
		$courseNames = mysqli_query($con,"SELECT Role FROM jobs WHERE StaffID='".$user."' and Course='".$course."'");						
		while($row = mysqli_fetch_array($courseNames))
		{
			$show = 1;
		}
		if($show == 0 and $Type != "Admin")
		{
				echo '<meta http-equiv="refresh" content="0; URL=http://localhost:8080/System/Home.php?q='.$user.'">';
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

    <!-- SB Admin CSS - Include with every page -->
    <link href="css/sb-admin.css" rel="stylesheet">
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
                <a class="navbar-brand" href="Home.php<?php echo '?q='.$user;?>">Demo</a>
            </div>
            <!-- /.navbar-header -->
            <!-- /.navbar-top-links -->
			 <ul class="nav navbar-top-links navbar-right">
				<li><font color="grey"><?php 
					echo $name;	
					
					?>
				</font></li>
				 <li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">
						<i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
					</a>
					<ul class="dropdown-menu dropdown-user">
						<li><a href="Login.php" onclick="Logout()"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
						</li>
					</ul>
						<!-- /.dropdown-user -->
                </li>
			</ul>
            <div class="navbar-default navbar-static-side" role="navigation">
                <div class="sidebar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="Home.php<?php echo '?q='.$user;?>"><i class="glyphicon glyphicon-home"></i> Home</a>
                        </li>
                        <li>
                            <a><i class="glyphicon glyphicon-book"></i> Courses<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
									<?php
									$con=mysqli_connect("localhost:3306","root","Changmin88","honours_project");
									//courses associated with account
									if($user == "ADMINS001")
									{
										$courseNames = mysqli_query($con,"SELECT Name FROM course");						
										while($row = mysqli_fetch_array($courseNames))
										{	
											$Course = $row['Name'];
											
											$testNames  = mysqli_query($con,"SELECT Name FROM test WHERE Course='".$Course."'");						
											$data = array();
											while($row2 = mysqli_fetch_array($testNames))
											{
												$data[] = $row2['Name'];
											}
											if(sizeOf($data)== 0)
											{
												echo '<li><a href="#">'.$Course.'</a></li>';
											}
											else
											{	
											echo '<li class="">
											<a>'.$Course.'<span class="fa arrow"></span></a>
											<ul class="nav nav-third-level collapse" style="height: 0px;">';
												foreach($data as $test)
												{
													echo '<li><a id="test" name="'.$Course.'/'.str_replace(" ", "_",$test).'" href="ViewFiles.php?q='.$user.'+'.$Course.'/'.str_replace(" ", "_",$test).'">'.$test.'</a></li>';
												}
												echo'</ul></li>';
											}
										
										}
									}
									else
									{
										$courseNames = mysqli_query($con,"SELECT Course FROM jobs WHERE StaffID='".$user."'");						
										while($row = mysqli_fetch_array($courseNames))
										{	
											$Course = $row['Course'];
											
											$testNames  = mysqli_query($con,"SELECT Name FROM test WHERE Course='".$Course."'");						
											$data = array();
											while($row2 = mysqli_fetch_array($testNames))
											{
												$data[] = $row2['Name'];
											}
											if(sizeOf($data)== 0)
											{
												echo '<li><a href="#">'.$Course.'</a></li>';
											}
											else
											{	
											echo '<li class="">
											<a>'.$Course.'<span class="fa arrow"></span></a>
											<ul class="nav nav-third-level collapse" style="height: 0px;">';
												foreach($data as $test)
												{
													echo '<li><a id="test" name="'.$Course.'/'.str_replace(" ", "_",$test).'" href="ViewFiles.php?q='.$user.'+'.$Course.'/'.str_replace(" ", "_",$test).'">'.$test.'</a></li>';
												}
												echo'</ul></li>';
											}
										}
									}
                              	mysqli_close($con);
								?>
                            </ul>
                        </li>
						<li>
                            <a><i class="glyphicon glyphicon-dashboard"></i> Dashboard<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="DashboardCourses.php?q=<?php echo $user;?>">Courses</a>
								</li>
								<li>
									<a href="DashboardStudent.php?q=<?php echo $user;?>">Student</a>
								</li>
							</ul>
                        </li>
						<li>
                            <a><i class="fa fa-edit fa-fw"></i>Administration<span class="fa arrow"></a>
							<ul class="nav nav-second-level">
                            <?php
									if($Type != "Tutor")
									{
										if($Type != "Lecturer")
										{
										echo '<li class="">
										<a>Staff Information<span class="fa arrow"></span></a>
										<ul class="nav nav-third-level collapse" style="height: 0px;">';
										echo'<li ><a href="ViewAllStaff.php?q='.$user.'">View All Staff</a></li>';
										echo'<li>
											<a href="AddStaff.php?q='.$user.'">Add Staff</a>
										</li>';
										echo'<li>
											<a href="AddJob.php?q='.$user.'">Assign Job</a>
										</li>';
										echo'</ul></li>';
										
										}
										echo '<li class="">
											<a>Course Information<span class="fa arrow"></span></a>
											<ul class="nav nav-third-level collapse" style="height: 0px;">';
											echo'<li>
											<a href="CourseInformation.php?q='.$user.'">View Course Information</a>
										</li>';
										if($Type == "Admin")
										{
										echo'<li>
											<a href="AddCourse.php?q='.$user.'">Add a Course</a>
										</li>';
										}
										
										echo '<li>
											<a href="AddTest.php?q='.$user.'">Add a Test</a>
										</li>';
										echo'<li>
											<a href="AddScript.php?q='.$user.'">Add a Script</a>
										</li>';
										echo'<li>
											<a href="AddStudents.php?q='.$user.'">Add Students</a>
										</li>';
										echo'</ul></li>';
									}
									
								?>
                            </ul>
                        </li>
                    </ul>
                    <!-- /#side-menu -->
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
					
					
			<div id="response">
			<div class="panel-group" id="testInformation">
			
				
	  
			<?php 
			$con=mysqli_connect("localhost:3306","root","Changmin88","honours_project");
									
			if(isset($_POST['Complete']))
			{
				//get tick information for each question
				$contentTicks = file_get_contents('Files/'.$_POST['Course'].'/'.str_replace(" ","_",$_POST['Test']).'/'.str_replace(" ","+",$_POST['Name']).'/tickType.txt');
				$contentTicks = explode("*", $contentTicks);
				//get information of test
				$content = file_get_contents("Files/".$_POST['Course'].'/'.str_replace(" ","_",$_POST['Test']).'/reformattedEndMarkers.txt');
				$content = explode("<split_marker>", $content);
				$marks = explode("\n", $content[0]);
				$temp = explode(" ", $contentTicks[0]);
				$question = "1";
				$sum = 0;
				$answer = "";
				//iterate through all marks and sum
				for($i = 0; $i < sizeOf($contentTicks)-1; $i++)
				{
					$temp = explode(" ", $contentTicks[$i]);
					if($question == $temp[1])
					{
						if($temp[0] == "tick")
						{
							$sum = $sum +1;
						}
						else if($temp[0] == "half")
						{
							$sum = $sum +0.5;
						}
					}
					else if($question != $temp[1])
					{
						$answer = $answer.'+'.$sum;

						$question = $question +1;
						$sum = 0;
						if($temp[0] == "tick")
						{
							$sum = $sum +1;
						}
						else if($temp[0] == "half")
						{
							$sum = $sum +0.5;
						}
					}
				}
				$answer = $answer.'+'.$sum;
				rename('Files/'.$_POST['Course'].'/'.str_replace(" ","_",$_POST['Test']).'/'.str_replace(" ","+",$_POST['Name']),'Files/'.$_POST['Course'].'/'.str_replace(" ","_",$_POST['Test']).'/'.$_POST['studentNumber']."+");
				//echo $_POST['Local']."<br>";
				//echo $_POST['Remote']."<br>";
				//ssh2_scp_send($connection,$_POST['Local'],$_POST['Remote'],0644);
				$ID = "";
				$testID  = mysqli_query($con,"SELECT testID FROM test WHERE Course='".$_POST['Course']."' AND Name='".$_POST['Test']."'");						
				while($row = mysqli_fetch_array($testID))
				{
					$ID = $row['testID'];
				}	
				$AddQuery ="INSERT INTO script (StudentNumber, Course, Test, Mark, Tutor,Remark, LastModified,Results) 
				VALUES
				('$_POST[studentNumber]','$_POST[Course]','$ID',$_POST[Mark],'$user','$_POST[Remark]', '$date','$answer')";
				mysqli_query($con, $AddQuery);
				$UpdateQuery ="Update flag SET Script='".$_POST['studentNumber']."' WHERE Script='".str_replace(" ","+",$_POST['Name'])."'";
				mysqli_query($con, $UpdateQuery);
				/*echo "<div class=".$greenAlert.">";
				echo $_POST['studentNumber']."'s mark was successfully saved.</div>";*/
			}
			//$info = $_REQUEST["q"];
			$info = explode("/", $sent[1]);
			$Course = $info[0];
			$Test = $info[1];

			echo '  <div class="row">
						<div class="page-header">
							<div class="row" width="100%">
								<div class="col-lg-5" width="100%">
									<h4><a href="#"> '.$Course.'</a><font color="#E8E8E8">   /  </font><font color="grey">'.str_replace("_", " ",$Test).'</font></h4>
								</div>
								<div class="text-right">
								<div class="col-xs-6 .col-sm-3" width="100%">
									 
									<p>
										<i class="btn btn-success btn-circle disabled" ><i class="fa fa-check" ></i></i>&nbsp;<font color="grey">Marked Script</font>&nbsp;
										<i class="btn btn-warning btn-circle disabled"><i class="glyphicon glyphicon-bookmark"></i></i>&nbsp;<font color="grey">Saved Script</font>&nbsp;
										<i class="btn btn-danger btn-circle disabled"><i class="glyphicon glyphicon-edit"></i></i>&nbsp;<font color="grey">Unmarked Script</font>&nbsp;
									</p>
									</div>
								</div>
							</div>
						</div>
							<!-- /.col-lg-12 -->
					</div>';
					
						
				echo'<!-- /.row -->
					
									
					<div class="row">
						
						<div class="col-lg-12">
						  
							<!-- .panel-heading -->
							<div class="panel-body">';
									
			echo '<div class="table-responsive"><table class="table table-hover">
			<thead><tr><th>Status</th><th>Filename</th><th>Marked By</th><th>Last Modified</th></tr></thead>
			<tbody>';
			$con=mysqli_connect("localhost:3306","root","Changmin88","honours_project");
			$ID = "";
			$testID = mysqli_query($con,"SELECT testID FROM test WHERE Course='".$Course."' And Name='".str_replace("_"," ",$Test)."'");	
			while($row = mysqli_fetch_array($testID))
			{	
				$ID = $row['testID'];
			}	
			//$output = shell_exec("ls /home/zmathews/Honours_Project/".$Course."/".str_replace(" ","_",$Test)."/");
			foreach (glob("Files/".$Course."/".str_replace(" ","_",$Test)."/*") as $name) 
			{
				if(is_dir($name))
				{	
					$name = explode("/", $name);
					
					
					if(file_exists('Files/'.$Course.'/'.str_replace(" ","_",$Test).'/'.$name[3]."/marks.txt")== 1)
					{
						if(strlen($name[3])<11)
						{
							$tutor = "";
							$mod = "";
							$info = mysqli_query($con,"SELECT Tutor, LastModified FROM script WHERE Course='".$Course."' AND Test='".$ID."' AND StudentNumber='".str_replace("+","",$name[3])."'");						
							while($row = mysqli_fetch_array($info))
							{	
								$tutor = $row['Tutor'];
								$mod = $row['LastModified'];
								
							}
							echo '<tr><td> <i class="btn btn-success btn-circle disabled" ><i class="fa fa-check"></i></i>&nbsp;</td><td><a href="ViewEditor.php?q='.$user.'*/'.$Course.'/'.str_replace(" ","_",$Test).'/'.$name[3].'/save2.png">'.str_replace("+","",strtoupper($name[3])).'</a></td><td>'.$tutor.'</td><td>'.$mod.'</td></tr>';
					
							
						}
						else
						{
							$display = explode("-",$name[3]);
							$displayName = $display[0].'-'.str_replace("_", " ", $display[1]);
							echo '<tr><td> <i class="btn btn-warning btn-circle disabled" " title="Saved Script"><i class="glyphicon glyphicon-bookmark"></i></i>&nbsp;</td>';
							echo '<td><a href="Editor.php?q='.$user.'*No*/'.$Course.'/'.str_replace(" ","_",$Test).'/'.$name[3].'/page2.png">'.$displayName.'</a></td><td></td><td></td></tr>';
					
						}
						
					}
					else
					{
						$display = explode("-",$name[3]);
						$displayName = $display[0].'-'.str_replace("_", " ", $display[1]);
						echo '<tr><td> <i class="btn btn-danger btn-circle disabled" ><i class="glyphicon glyphicon-edit"></i></i>&nbsp;</td>';
						echo '<td><a href="Editor.php?q='.$user.'*No*/'.$Course.'/'.str_replace(" ","_",$Test).'/'.$name[3].'/page2.png">'.$displayName.'</a></td><td></td><td></td></tr>';
					
					}
					
					
				}
			}
			echo '</div></div></div></div>';
			mysqli_close($con);
			?>		
			
			</div>
			</div>	
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
	<script>
	function Logout() {
		
		var info = document.getElementById("user").value;
		//alert(info);
		var xmlhttp=new XMLHttpRequest();
		  xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			  //document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
			  //alert(xmlhttp.responseText);
			}
		  }
		  xmlhttp.open("GET","Logout.php?q="+info,true);
		  xmlhttp.send();
	}
	</script>
    <!-- Core Scripts - Include with every page -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <!-- Page-Level Plugin Scripts - Panels and Wells -->

    <!-- SB Admin Scripts - Include with every page -->
    <script src="js/sb-admin.js"></script>

	<script>
	$(function () { $("[data-toggle='tooltip']").tooltip(); });
	document.addEventListener('click', function(e) {
		if(e.target.id == "test")
		{
			var info = document.getElementById("user").value+"*"+e.target.name;
			
			var xmlhttp=new XMLHttpRequest();
			xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
				//alert(info);
			  document.getElementById("response").innerHTML=xmlhttp.responseText;
			  //alert(xmlhttp.responseText);
			}
			}
			xmlhttp.open("GET","testFiles.php?q="+info,true);
			xmlhttp.send();
		}
	});
	</script>

    <!-- Page-Level Demo Scripts - Panels and Wells - Use for reference -->

</body>

</html>
