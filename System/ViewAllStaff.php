<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php 
	$con=mysqli_connect("localhost:3306","root","Changmin88","honours_project");
	$sent = explode(" ", $_REQUEST["q"]); 
	$user = $sent[0];
	//checks if there is no StaffID
	if(isset($_REQUEST["q"])==0)
	{
		echo '<meta http-equiv="refresh" content="0; URL=http://localhost:8080/System/Login.php">';
	}
	else
	{
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
		if($Type == "Tutor" or $Type == "Lecturer")
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
    <title>Add A Course</title>

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
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">View All Staff</h1>
					<?php echo '<input type="hidden" value="'.$user.'" id="user"';?>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            
            <!-- /.row -->
            <div class="row">
				
                <div class="col-lg-12">
                  
					<!-- .panel-heading -->
					<div class="panel-body">
						<ul class="nav nav-pills">
						<?php
							if($Type == "Admin")
							{
							echo'<li class="active"><a>View All Staff</a></li>';
							echo'<li><a href="AddStaff.php?q='.$user.'">Add Staff</a></li>';
							echo '<li>
								<a href="AddJob.php?q='.$user.'">Add a Job</a>
							</li></ul>';
							}
							$con=mysqli_connect("localhost:3306","root","Changmin88","honours_project");
							
							if(isset($_POST['Submit']))
							{
								$name = substr($_POST['Name'],0,3);
								$surname = str_split($_POST['Surname']);
								$fullname = $_POST['Name']." ".$_POST['Surname'];
								$count = 0;
								$answer = $surname[0];
								for($i = 1; $i<sizeOf($surname); $i++)
								{
									if($surname[$i] != "a" and $surname[$i] != "e" and $surname[$i] != "i" and $surname[$i] != "o" and $surname[$i] != "u")
									{
										if($count < 2)
										{
											$answer = $answer.$surname[$i];
											$count ++;
										}
									}
								}
								if(strlen($name) < 3)
								{
									if(strlen($name) == 0)
									{
										$name = "XXX";
									}
									if(strlen($name) == 1)
									{
										$name = $name."XX";
									}
									if(strlen($name) == 2)
									{
										$name = $name."X";
									}
								}
								if($count == 0)
								{
									$answer = $answer."XX";
								}
								else if($count == 1)
								{
									$answer = $answer."X";
								}
								
								$done = 0;
								$ID = "";
								$number = 1;
								$last = 0;
								while($done != 1)
								{	
									if($last != $number)
									{
										$last = $number;
										if($number <10)
										{
										$ID = strtoupper($answer).strtoupper($name)."00".$number;
										}
										else if($number <100)
										{
											$ID = strtoupper($answer).strtoupper($name)."0".$number;
										}
										else
										{
										
											$ID = strtoupper($answer).strtoupper($name).$number;
										}
										$result = mysqli_query($con,"SELECT Name FROM staff WHERE StaffID='".$ID."'");						
										while($staff = mysqli_fetch_array($result))
										{
											$number ++;
										}
															
									}
									else if($last == $number)
									{
										$pass = 'pass_'.$ID;
										
										$AddQuery ="INSERT INTO staff (StaffID, name, Status, Type, Password) 
											VALUES
											('$ID','$fullname','Not Active','Nothing','".crypt($pass, 'PASSWORD_DEFAULT')."')";
											mysqli_query($con, $AddQuery);
										$done = 1;
									}
								}
								
								
							}
							if(isset($_POST['JobSubmit']))
							{
							
								$add = 0;
								$result = mysqli_query($con,"SELECT * FROM jobs WHERE StaffID='".$_POST['StaffID']."' AND Role='".$_POST['Role']."' AND Course='".$_POST['Course']."'");						
								while($staff = mysqli_fetch_array($result))
								{
									$add = 1;
								}
								if($add == 0)
								{
									
									$role = "";
									$result = mysqli_query($con,"SELECT Type FROM staff WHERE StaffID='".$_POST['StaffID']."'");						
									while($staff = mysqli_fetch_array($result))
									{
										$role = $staff['Type'];
									}
									
									if($role != $_POST['Role'] and $role != 'Admin' and $role != 'TA' and $role != 'CC')
									{
										if($role == "Tutor" and $_POST['Role'] == "Lecturer")
										{
											$role = $_POST['Role'];
										}
										else if($role == "Nothing")
										{
											$role = $_POST['Role'];
										}
									}

									$AddQuery ="INSERT INTO jobs (StaffID, Course, Role) VALUES	('".$_POST['StaffID']."','".$_POST['Course']."','".$_POST['Role']."')";
									mysqli_query($con, $AddQuery);
									//update role and status in staff
									$UpdateQuery ="Update staff SET Type='".$role."', Status='Active' WHERE StaffID='".$_POST['StaffID']."'";
									mysqli_query($con, $UpdateQuery);
								}
								
							}
							echo'<!-- /.row -->
							<div class="row"><div class="col-lg-12"><!-- .panel-heading --><div class="panel-body">';
												
							echo '<div class="table-responsive"><table class="table table-hover">
							<thead><tr><th>Staff ID</th><th>Name</th><th>Role</th><th>Status</th></tr></thead>
							<tbody>';
							$result = mysqli_query($con,"SELECT * FROM staff");						
							while($staff = mysqli_fetch_array($result))
							{
								echo '<tr><td>'.$staff['StaffID'].'</td><td>'.$staff['name'].'</td><td>'.$staff['Type'].'</td><td>'.$staff['Status'].'</td></tr>';
							}
									
							echo '</tbody></table></div></div></div></div>';				
								mysqli_close($con);
						?>
					</div>
                    
                </div>
                <!-- /.col-lg-12 -->
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

    <!-- Page-Level Demo Scripts - Panels and Wells - Use for reference -->

</body>

</html>
