<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php 
	$con=mysqli_connect("localhost:3306","root","Changmin88","honours_project");
	//Authentication Checks
	//checks if there is no StaffID
	if(isset($_REQUEST["q"])==0)
	{
		echo '<meta http-equiv="refresh" content="0; URL=http://localhost:8080/System/Login.php">';
	}
	else
	{
		//Checks if StaffID is valid
		$Name = mysqli_query($con,"SELECT name, Type, LastLogin, LastLogout FROM staff WHERE StaffID='".$_REQUEST["q"]."'");	
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
		echo'<script> function loadpage(){$("body").show(); $(\'#calendar\').fullCalendar(\'render\');}</script>';
	}
	mysqli_close($con);	
	?>
	
    <title>Home</title>
	<!-- Core CSS - Include with every page -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    
    <!-- Core CSS - Include with every page -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Page-Level Plugin CSS - Panels and Wells -->

    <!-- SB Admin CSS - Include with every page -->
    <link href="css/sb-admin.css" rel="stylesheet">
	 <!-- Calendar -->
	<link href='css/fullcalendar.css' rel='stylesheet' />
	<link href='css/fullcalendar.print.css' rel='stylesheet' media='print' />
	
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
                <a class="navbar-brand">Demo</a>
				
            </div>
			
			 <ul class="nav navbar-top-links navbar-right">
				<li><font color="grey"><?php echo $name;?>
				</font></li>
				 <li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">
						<i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
					</a>
					<ul class="dropdown-menu dropdown-user">
						<li><a href="UserProfile.php?q=<?php  echo $_REQUEST["q"];?>"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
						<li class="divider"></li>
						<li><a href="Login.php" onclick="Logout()"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
						</li>
						<li></li>
					</ul>
						<!-- /.dropdown-user -->
                </li>
			</ul>
			
					
			 
            <!-- /.navbar-header -->
            <!-- /.navbar-top-links -->

            <div class="navbar-default navbar-static-side" role="navigation">
                <div class="sidebar-collapse">
				<ul class="nav" id="side-menu">
				
						
                        <li>
                            <a><i class="glyphicon glyphicon-home"></i> Home</a>
                        </li>
                        <li>
						<!-- Courses panel-->
                            <a><i class="glyphicon glyphicon-book"></i> Courses<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<?php
									$con=mysqli_connect("localhost:3306","root","Changmin88","honours_project");
									//courses associated with account
									$staffCourses = array();
									if($_REQUEST["q"] == "ADMINS001")
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
													echo '<li><a id="test" name="'.$Course.'/'.str_replace(" ", "_",$test).'" href="ViewFiles.php?q='.$_REQUEST["q"].'+'.$Course.'/'.str_replace(" ", "_",$test).'">'.$test.'</a></li>';
												}
												echo'</ul></li>';
											}
										
										}
									}
									else
									{
										$courseNames = mysqli_query($con,"SELECT Course FROM jobs WHERE StaffID='".$_REQUEST["q"]."'");						
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
													echo '<li><a id="test" name="'.$Course.'/'.str_replace(" ", "_",$test).'" href="ViewFiles.php?q='.$_REQUEST["q"].'+'.$Course.'/'.str_replace(" ", "_",$test).'">'.$test.'</a></li>';
												}
												echo'</ul></li>';
											}
										
										}

									
									}
                              	mysqli_close($con);
								$user = $_REQUEST["q"];
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
						<!-- Admin panel-->
                            <a><i class="fa fa-edit fa-fw"></i>Administration<span class="fa arrow"></span></a>
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
			<div class="panel-group" id="testInformation">
				<div class="row">
				<br>
					<?php 
						$con=mysqli_connect("localhost:3306","root","Changmin88","honours_project");
						$adminRights = array();
						$rights = mysqli_query($con,"SELECT Course, Role FROM jobs WHERE StaffID='".$user."'");						
						while($row = mysqli_fetch_array($rights))
						{
							if($row['Role'] == "Course Convener" or $row['Role'] == "Teaching Assistant")
							{
								$adminRights[] = $row['Course'];
							}
						}
						$result = mysqli_query($con,"SELECT Course,Date,Name,testID FROM test");					
						$answer = "";
						$number = array();
						while($rs = mysqli_fetch_array($result)) 
						{
							if($user != "ADMINS001")
							{
								foreach($adminRights as $allow)
								{
									if($allow == $rs['Course'] )
									{
										$date =explode("-",$rs["Date"]);
										$answer = $answer. $rs["Course"] .': '.$rs["Name"].',' .$date[2].'-'.$date[1].'-'.$date[0]. '*'; 
										
										$numFiles = -1;
										foreach (glob("Files/".$rs["Course"]."/".str_replace(" ","_",$rs["Name"])."/*") as $name) 
										{
											
											$numFiles  = $numFiles +1;
										}
										$number[] = $numFiles;
									}
									
								}
							}
							else
							{
								$date =explode("-",$rs["Date"]);
								$answer = $answer. $rs["Course"] .': '.$rs["Name"].',' .$date[2].'-'.$date[1].'-'.$date[0]. '*'; 
								$countTests = 0;
								$tests = mysqli_query($con,"SELECT Test FROM script WHERE Course='".$rs["Course"]."' AND Test='".$rs["testID"]."'");						
								while($test = mysqli_fetch_array($tests))
								{
									$countTests++;
								}
								$numFiles = -1;
								foreach (glob("Files/".$rs["Course"]."/".str_replace(" ","_",$rs["Name"])."/*") as $name) 
								{
									
									$numFiles  = $numFiles +1;
								}
								$number[] = $rs["Course"].': '.$rs["Name"].', '.$countTests.'/'.$numFiles;
							}
						}
						$answer = substr($answer,0,sizeOf($answer)-2);
		
						mysqli_close($con);
					?>
					<div class="col-lg-5">
					<div class="row">
	
					<?php  
					foreach($number as $value)
					{
					$color = "";
					$information = explode(", ", $value);
					if($information[1] <0.5)
					{
						$color = "rgba(217,83,79,0.6)";
					}				
					else if($information[1]>= 0.5)
					{
						$color = "rgba(255,219,73,0.6)";
					}
					else if($information[1]== 1)
					{
						$color = "rgba(92,184,92,0.6)";
					}
					echo '<div class=" col-md-6">
		<div class="panel panel-primary" style="border-color:'.$color.';">
			<div class="panel-heading" style="background-color:'.$color.'">
				<div class="row"><div class="col-xs-3" >
						<i class="glyphicon glyphicon-inbox" style="height:60px;font-size:60px"></i>
					</div>
					<div class="col-xs-9 text-right" width="100%">';
						echo'<h2>'.$information[1].'</h2>';
						echo'<div style="font-size:15px">'.$information[0].'</div></div></div>
								</div>
							</div>
						</div>	';}?>
									
					</div>
					<div class="row">
					<br>
					<div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bell fa-fw"></i> Notifications Panel
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="list-group" id="notificationPanel">
							<?php
							$con=mysqli_connect("localhost:3306","root","Changmin88","honours_project");
							$result = mysqli_query($con,"SELECT * FROM flag WHERE Status='Alert'");					
								while($rs = mysqli_fetch_array($result)) 
								{
									if($user != "ADMINS001")
									{
									foreach($adminRights as $allow)
									{
										if($allow == $rs['Course'] )
										{
										echo '<a href="#" id="notification" name="'.$rs['flagID'].'*'.$rs['Course'].' Script Flagged" class="list-group-item" data-toggle="modal" data-target="#myModal" onclick="setModal(\''.$rs['Comment'].'\')">
										 <i class="glyphicon glyphicon-flag"></i>  '.$rs['Course'].' Script Flagged</a>';
										 }
									}
									}
									else
									{
										echo '<a href="#" id="notification" name="'.$rs['flagID'].'*'.$rs['Course'].' Script Flagged" class="list-group-item" data-toggle="modal" data-target="#myModal" onclick="setModal(\''.$rs['Comment'].'\')">
										 <i class="glyphicon glyphicon-flag"></i>  '.$rs['Course'].' Script Flagged</a>';
									}
								}
							
							mysqli_close($con);
							?>
							</div>
								<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            <h4 class="modal-title" id="myModalLabel"></h4>
                                        </div>
                                        <div class="modal-body" id="body">
                                        </div>
										<div class="modal-footer">
									<button type="button" id="resolve" class="btn btn-default" data-dismiss="modal" onClick="resolve()">Resolve</button>
									</div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
								
                                <!-- /.modal-dialog -->
                            </div>
                             
                            <!-- /.list-group -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
					</div>
					</div>
					<div class="col-lg-7">
					<div id='calendar' class="well"></div>
					</div>
 
					<!-- /.col-lg-12 -->
				</div>
			</div>	
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->

    <!-- Core Scripts - Include with every page -->
      <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
	<script src='lib/moment.min.js'></script>
	<script src='js/fullcalendar.min.js'></script>
<script>

	$(document).ready(function() {

			$('#calendar').fullCalendar({
				
				editable: false,
				eventLimit: true, // allow "more" link when too many events
				events: [
					
						<?php 
						$line = explode("*", $answer);
						$count = 0;
						foreach($line as $data)
						{
							$data = explode(",", $data);
							if(substr($data[0],0,8) == "CSC1010H")
							{
								$color = "rgba(107,198,225,0.6)";
							}
							else 
							{
								$color = "rgba(92,184,92,0.6)";
							}
							if(	$count < sizeOf($line)-1)
							{
								echo'{title: \''.substr($data[0],0,8).'\',
								start: \''.$data[1].'\', 
								description: \''.$data[0].'\',
								color: \''.$color.'\'},';
							}
							else
							{
								echo'{title: \''.substr($data[0],0,8).'\',
								start: \''.$data[1].'\', 
								description: \''.$data[0].'\',
								color: \''.$color.'\'}';
							}
							$count++;
						}
						?>
					
				],
				eventMouseover: function(data, event, view) {
					var tooltip = data.description;
					$(this).attr("data-original-title", tooltip)
					$(this).tooltip({ container: "body"})
				}
			});
			    
		
	});
	function setModal(value)
	{
		var flag = document.getElementById("notification").name.split("*");
		document.getElementById("myModalLabel").innerHTML = flag[1];
		document.getElementById("body").innerHTML = value+". (<a href=#>Link</a>)";
		document.getElementById("resolve").name = flag[0]; 
	}
		$(function() 
	{ 
		//button tooltips
		$("[data-toggle='tooltip']").tooltip(); 
	});
	function resolve()
	{
		flagID = document.getElementById("resolve").name;
		var xmlhttp=new XMLHttpRequest();
		xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById("notificationPanel").innerHTML=xmlhttp.responseText;
			}
		}
		xmlhttp.open("GET","ResolveFlag.php?q="+flagID,true);
		xmlhttp.send();
	}
</script>

    <!-- Page-Level Plugin Scripts - Panels and Wells -->

    <!-- SB Admin Scripts - Include with every page -->
    <script src="js/sb-admin.js"></script>
	<script>
	function Logout() {
		
		var info = document.getElementById("user").value;
		//alert(info);
		var xmlhttp=new XMLHttpRequest();
		  xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			  //document.getElementById("notificationPanel").innerHTML=xmlhttp.responseText;
			  //alert(xmlhttp.responseText);
			}
		  }
		  xmlhttp.open("GET","Logout.php?q="+info,true);
		  xmlhttp.send();
	}
	</script>

    <!-- Page-Level Demo Scripts - Panels and Wells - Use for reference -->

</body>

</html>
