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
		echo'<script> function loadpage(){$("body").show();}</script>';
	}
	mysqli_close($con);	
	?>
	
    <title>Dashboard</title>
	<!-- Core CSS - Include with every page -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    
    <!-- Core CSS - Include with every page -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Page-Level Plugin CSS - Panels and Wells -->
	<link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
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
                <a href="Home.php?q=<?php echo $_REQUEST["q"];?>" class="navbar-brand">Demo</a>
				
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
                            <a href="Home.php?q=<?php echo $_REQUEST["q"];?>"><i class="glyphicon glyphicon-home"></i> Home</a>
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

					<div class="table-responsive">
                                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline" role="grid"><table class="table table-hover" id="dataTables-example" aria-describedby="dataTables-example_info">
                                    <thead>
                                        <tr role="row"><th class="sorting_asc" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 178px;" aria-sort="ascending">Student Numbers</th><th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" style="width: 116px;">Grade Average</th><th rowspan="1" colspan="1"  style="width: 116px;">Symbol</th></tr>
                                    </thead>
                                    <tbody>
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
										$students = array();
										$getStudents = mysqli_query($con,"SELECT DISTINCT StudentNumber FROM registered_students");						
										while($row = mysqli_fetch_array($getStudents))
										{
											$students[] = $row['StudentNumber'];
											$marks = array();
											$test = array();
											$getResults= mysqli_query($con,"SELECT * FROM script WHERE StudentNumber='".$row['StudentNumber']."'");						
											while($rows = mysqli_fetch_array($getResults))
											{
												$marks[] = $rows['Mark'];
												$test[] = $rows['Test'];
											}
											$sum = 0;
											for($i =0; $i< sizeOf($test); $i++)
											{
												$getTotal= mysqli_query($con,"SELECT Course, Name FROM test WHERE testID='".$test[$i]."'");						
												while($total = mysqli_fetch_array($getTotal))
												{
													$content = file_get_contents("Files/".$total['Course']."/".str_replace(" ", "_",$total['Name'])."/reformattedEndMarkers.txt");
													$content = explode("<split_marker>", $content);
													$mark = explode("\n", $content[0]);
													$totalMark = trim($mark[0]);
					
													if($totalMark != 0)
													{
														$sum = $sum + (($marks[$i]/$totalMark)*100);
													//$sum = $sum + $marks[$i];
													}
												}
											}
											$color = "";
											if($sum != 0)
											{
												if($sum/sizeOf($test) >= 75)
												{
													$color = "#5bc0de";
												}
												else if($sum/sizeOf($test) < 75 and $sum/sizeOf($test) >= 70)
												{
													$color = "#5cb85c";
												}
												else if($sum/sizeOf($test) < 70 and $sum/sizeOf($test) >= 60)
												{
													$color = "#FFDB4D";
												}
												else if($sum/sizeOf($test) < 60 and $sum/sizeOf($test) >= 50)
												{
													$color = "#FF9933";
												}
												else if($sum/sizeOf($test) < 50)
												{
													$color = "#d9534f";
												}
												$sum = number_format(($sum/sizeOf($test)),1);
											}
											
											echo '<tr class="gradeA odd" data-toggle="modal" data-target="#myModal" onClick="changeInformation(\''.$row['StudentNumber'].'\')"><td class="sorting_1">'.$row['StudentNumber'].'</td>
                                            <td class="center ">'.$sum.'%</td><td><button class="btn btn-default btn-circle" style="background-color:'.$color.';" disabled></button></td></tr>';
											
										}
									?>
									</tbody>
                                </table></div>
								
					<!-- /.col-lg-12 -->
				</div>
				<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
								<h4 class="modal-title" id="myModalLabel">Modal title</h4>
							</div>
							<div class="modal-body">
							</div>
							
						</div>
						<!-- /.modal-content -->
					</div>
					<!-- /.modal-dialog -->
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
<script src="js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>
<script src="js/Chart.js"></script>	
    <!-- Page-Level Plugin Scripts - Panels and Wells -->

	<script>
    $(document).ready(function() {
        $('#dataTables-example').dataTable();
    });
    </script>
    <!-- SB Admin Scripts - Include with every page -->
    <script src="js/sb-admin.js"></script>
	<script>
	function changeInformation(student)
	{
		//document.getElementById("myModalLabel").innerHTML = student;
		var xmlhttp=new XMLHttpRequest();
		  xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			  document.getElementById("myModal").innerHTML=xmlhttp.responseText;
			  //alert(xmlhttp.responseText);
			}
		  }
		  xmlhttp.open("GET","test.php?q="+student,true);
		  xmlhttp.send();
		  loadGraph();
	}
	function loadGraph()
	{
var randomScalingFactor = function(){ return Math.round(Math.random()*100)};

	var barChartData = {
		labels : ["Questions"],
		datasets : [
			{
				fillColor : "rgba(220,220,220,0.5)",
				strokeColor : "rgba(220,220,220,0.8)",
				highlightFill: "rgba(220,220,220,0.75)",
				highlightStroke: "rgba(220,220,220,1)",
				data : [randomScalingFactor()]
			},
			{
				fillColor : "rgba(151,187,205,0.5)",
				strokeColor : "rgba(151,187,205,0.8)",
				highlightFill : "rgba(151,187,205,0.75)",
				highlightStroke : "rgba(151,187,205,1)",
				data : [randomScalingFactor()]
			}
			,
			{
				fillColor : "rgba(151,187,205,0.5)",
				strokeColor : "rgba(151,187,205,0.8)",
				highlightFill : "rgba(151,187,205,0.75)",
				highlightStroke : "rgba(151,187,205,1)",
				data : [randomScalingFactor()]
			},
			{
				fillColor : "rgba(151,187,205,0.5)",
				strokeColor : "rgba(151,187,205,0.8)",
				highlightFill : "rgba(151,187,205,0.75)",
				highlightStroke : "rgba(151,187,205,1)",
				data : [randomScalingFactor()]
			},
			{
				fillColor : "rgba(151,187,205,0.5)",
				strokeColor : "rgba(151,187,205,0.8)",
				highlightFill : "rgba(151,187,205,0.75)",
				highlightStroke : "rgba(151,187,205,1)",
				data : [randomScalingFactor()]
			},
			{
				fillColor : "rgba(151,187,205,0.5)",
				strokeColor : "rgba(151,187,205,0.8)",
				highlightFill : "rgba(151,187,205,0.75)",
				highlightStroke : "rgba(151,187,205,1)",
				data : [randomScalingFactor()]
			}
		]

	}
	
		var ctx = document.getElementById("canvas").getContext("2d");
		window.myBar = new Chart(ctx).Bar(barChartData, {
			responsive : true
		});
	
		
	}

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
