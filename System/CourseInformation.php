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
									if(isset($_POST['SubmitStudents']))
									{
										$fileContents = file_get_contents($_FILES["file"]["tmp_name"]);
										$fileContents = explode("\n", $fileContents);
										//name;ID;email;role
										for($i = 0; $i<sizeOf($fileContents)-1; $i++)
										{
											$temp = explode(";", $fileContents[$i]);
											//echo ($temp[3]);
											if(trim($temp[3]) == "Student")
											{
												echo $temp[1]."<br>";
												$AddQuery ="INSERT INTO registered_students (StudentNumber, Course, Email) VALUES	('".trim($temp[1])."','".$_POST['Course']."','".trim($temp[2])."')";
												mysqli_query($con, $AddQuery);
											}
										}
									}
									// When a course is added
									if(isset($_POST['SubmitTest']))
									{
										
										
										//check if course exists
										$addTest = 0;
										/*$checkCourse = "SELECT * FROM course WHERE Name='".$_POST['Course']."'";
										$resultCheck = mysql_query($checkCourse)or die(mysql_error());
										while($row = mysql_fetch_array($resultCheck, MYSQL_ASSOC))
										{
											$addTest = $addTest +1;
										}*/
										$checkCourse = mysqli_query($con,"SELECT * FROM course WHERE Name='".$_POST['Course']."'");						
										while($row = mysqli_fetch_array($checkCourse))
										{
											$addTest = $addTest +1;
										}
										
										if($addTest == 1)
										{
											
											//directory of test
											$dir = $_POST['Course'].'/'.str_replace(" ","_",$_POST['Test']);
											
											//create test folder
											//$cmd =  "mkdir /home/zmathews/Honours_Project/".$dir;
											//ssh2_exec($connection,$cmd);
											
											//ftp_mkdir($conn_id, $dir);
											mkdir("Files/".$dir);
											if ($_FILES["file"]["error"] > 0) 
											{
												echo "<div class=".$redAlert.">";
												echo "Error: " . $_FILES["file"]["error"] . "</div><br>";
											} 
											else 
											{
												
												//$dest_file = '/home/zmathews/Honours_Project/'.str_replace(" ","_",$_POST['Course']).'/'.str_replace(" ","_",$_POST['Test']).'/'.$_FILES["file"]["name"];
												$dest_file = 'Files/'.str_replace(" ","_",$_POST['Course']).'/'.str_replace(" ","_",$_POST['Test']).'/';
															
												//ssh2_scp_send($connection,$_FILES["file"]["tmp_name"],$dest_file,0644);
												// initiate download

												if (file_exists($dest_file . $_FILES["file"]["name"])) 
												{
													echo $_FILES["file"]["name"] . " already exists. ";
												} 
												else 
												{
													move_uploaded_file($_FILES["file"]["tmp_name"],$dest_file. $_FILES["file"]["name"]);
													//echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
												}

											}
											
											//Question type that will be inserted in DB
											$QuestionType = "";
											
											for($x=1; $x<=$_POST['NumQuestions']; $x++)
											{	
												$ref = "q".$x;
												$QuestionType = $QuestionType.'+'.$_POST[$ref];
											}
											
											//add to database
											//$AddTest = "INSERT INTO test (Name,Course,testID,NumberOfQuestions,TypeOfQuestions,Date)	
											//VALUES ('$_POST[Test]','$_POST[Course]',$_POST[TestID],$_POST[NumQuestions], '$QuestionType', Date )";
											//mysql_query($AddTest) or die(mysql_error());
											$AddTest ="INSERT INTO test (Name,Course,testID,NumberOfQuestions,TypeOfQuestions,Date)	
											VALUES ('$_POST[Test]','$_POST[Course]',$_POST[TestID],$_POST[NumQuestions], '$QuestionType', '$_POST[Date]' )";
											mysqli_query($con, $AddTest);									
											
											echo "<div class=".$greenAlert.">";
											echo $_POST['Test']." was successfully added.</div>";
											
										}
										else
										{
											
											echo "<div class=".$redAlert.">";
											echo $_POST['Test']." could not be added.</div>";
										}
									}
										if(isset($_POST['Upload']))
									{
											/*if ($_FILES["file"]["error"] > 0) 
											{
												echo "<div class=".$redAlert.">";
												echo "Error: " . $_FILES["file"]["error"] . "</div><br>";
											} 
											else 
											{
												
												//$dest_file = '/home/zmathews/Honours_Project/'.str_replace(" ","_",$_POST['Course']).'/'.str_replace(" ","_",$_POST['Test']).'/'.$_FILES["file"]["name"];
												$dest_file = 'Files/'.str_replace(" ","_",$_POST['Course']).'/'.str_replace(" ","_",$_POST['Test']).'/';
												
												//ssh2_scp_send($connection,$_FILES["file"]["tmp_name"],$dest_file,0644);
												


											}*/
											$dest_file = 'Files/'.str_replace(" ","_",$_POST['Course']).'/'.str_replace(" ","_",$_POST['Test']).'/'.$_FILES["file"]["name"];
											if (file_exists($dest_file . $_FILES["file"]["name"])) 
											{
												echo $_FILES["file"]["name"] . " already exists. ";
											} 
											else 
											{
												move_uploaded_file($_FILES["file"]["tmp_name"],$dest_file. $_FILES["file"]["name"]);
												//echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
											}
									}
								if(isset($_POST['Submit']))
								{	
									//add condition
									$addCourse = 0;
									/*$checkCourse = "SELECT * FROM course WHERE Name='".$_POST['Course']."'";
									$resultCheck = mysql_query($checkCourse)or die(mysql_error());
									while($row = mysql_fetch_array($resultCheck, MYSQL_ASSOC))
									{
										$addCourse = $addCourse +1;
									}*/
									$checkCourse = mysqli_query($con,"SELECT * FROM course WHERE Name='".$_POST['Course']."'");						
									while($row = mysqli_fetch_array($checkCourse))
									{
										$addCourse = $addCourse +1;
									}
									//makes sure directory has no whitespaces
									//$dir = "/home/zmathews/Honours_Project/".str_replace(" ","_",$_POST['Course']);
									$dir = "Files/".str_replace(" ","_",$_POST['Course']);
									//if folder doesn't exist
									if($addCourse == 0)
									{
										//echo $_POST['Course']." ".$_POST['CC']." ".$_POST['TA'];
										//add to database
										//$AddCourse = "INSERT INTO course VALUES ('$_POST[Course]','$_POST[Convenor]','$_POST[TA]',0)";
										//mysql_query($AddCourse) or die(mysql_error());
										$AddCourse ="INSERT INTO course VALUES ('".$_POST['Course']."','".$_POST['CC']."','".$_POST['TA']."')";
										mysqli_query($con, $AddCourse);
										
										
										//create folder 
										mkdir($dir);
										
										//$cmd =  "mkdir ".$dir;
										//ssh2_exec($connection,$cmd);
										//ftp_mkdir($connection, $dir);
										
										//adding in role of Course Convenor
										$role = "";
										$result = mysqli_query($con,"SELECT Type FROM staff WHERE StaffID='".$_POST['CC']."'");						
										while($staff = mysqli_fetch_array($result))
										{
											//other role
											$role = $staff['Type'];
										}
										
										if($role != "Course Convener" and $role != 'Admin')
										{
											
												$role = "Course Convener";
										}

										$AddQuery ="INSERT INTO jobs (StaffID, Course, Role) VALUES	('".$_POST['CC']."','".$_POST['Course']."','Course Convener')";
										mysqli_query($con, $AddQuery);
										//update role and status in staff
										$UpdateQuery ="Update staff SET Type='".$role."', Status='Active' WHERE StaffID='".$_POST['CC']."'";
										mysqli_query($con, $UpdateQuery);
										
											//adding in role of Teaching Assistant
											$roleT = "";
											$result = mysqli_query($con,"SELECT Type FROM staff WHERE StaffID='".$_POST['TA']."'");						
											while($staff = mysqli_fetch_array($result))
											{
												//other role
												$roleT = $staff['Type'];
											}
											
											if($roleT != "Teaching Assistant" and $roleT != 'Admin' and $roleT != 'Course Convener')
											{
												
													$roleT = "Teaching Assistant";
											}

											$AddQuery ="INSERT INTO jobs (StaffID, Course, Role) VALUES	('".$_POST['TA']."','".$_POST['Course']."','Teaching Assistant')";
											mysqli_query($con, $AddQuery);
											//update role and status in staff
											$UpdateQuery ="Update staff SET Type='".$roleT."', Status='Active' WHERE StaffID='".$_POST['TA']."'";
											mysqli_query($con, $UpdateQuery);
											
											//success message
											echo '<div class="alert alert-success">';
											echo $_POST['Course']." was successfully added.</div>";
											
											
										}
										//if folder does exist
										else
										{
											echo '<div class="alert alert-danger">';
											echo $_POST['Course']." could not be added.</div>";
										}												
									}	
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
                    <h1 class="page-header">Course Information</h1>
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
						echo'<li class="active"><a>View Course Information</a></li>';
							if($Type == "Admin")
							{
							echo'<li><a href="AddCourse.php?q='.$user.'">Add a Course</a></li>';
							}
							if($Type != "Tutor")
							{
							
							echo '<li>
								<a href="AddTest.php?q='.$user.'">Add a Test</a>
							</li>';
							echo'<li>
								<a href="AddScript.php?q='.$user.'">Add a Script</a>
							</li>';
							}
							echo '</ul><br>';
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
						
							//prints out all course information
							$result = mysqli_query($con,"SELECT * FROM course");						
							while($course = mysqli_fetch_array($result))
							{
								$admin = 0;
								for($r = 0; $r < sizeOf($adminRights); $r++)
								{
									if($course['Name'] == $adminRights[$r])
									{
										$admin = 1;
									}
								}
								
								echo'<div class="panel panel-default">
									<div class="panel-heading">'.$course['Name'].'</div>
									<div class="panel-body">
									<div class="row">
									<div class="col-md-6">
										<div class="list-group">
											<h4 class="list-group-item">Staff Information:</h4>
										
										<div class="list-group-item">
											<u>Course Convener:</u>&nbsp;';
											$lecturerResult = mysqli_query($con,"SELECT name FROM staff WHERE StaffID='".$course['Lecturer']."'");						
											while($lecturerName = mysqli_fetch_array($lecturerResult))
											{
												echo $lecturerName['name'];
											}
											
											
										echo'</div>
										<div class="list-group-item">
											<u>Teaching Assistant:</u>&nbsp;';
											$TAResult = mysqli_query($con,"SELECT name FROM staff WHERE StaffID='".$course['TeachingAssistant']."'");						
											while($TAName = mysqli_fetch_array($TAResult))
											{
												echo $TAName['name'];
											}
											
										echo'</div>
										<div class="list-group-item">
										<u>Lecturer:</u>&nbsp;';
											$lecturerResults = mysqli_query($con,"SELECT StaffID FROM jobs WHERE Role='Lecturer' AND Course='".$course['Name']."'");						
											while($lecturer = mysqli_fetch_array($lecturerResults))
											{
												$r = mysqli_query($con,"SELECT * FROM staff WHERE StaffID='".$lecturer['StaffID']."'");				
												while($l = mysqli_fetch_array($r))
												{
													if($user == "ADMINS001" or $admin == 1)
													{
														echo '<div class="btn btn-default"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" onclick="deleteRole(\''.$tutor['StaffID'].'*'.$course['Name'].'*Lecturer\')">×</button>'.$l['name'].'&nbsp;</div><br>';
													}
													else
													{
														echo '<li>'.$l['name'].'</li>';
													}
												}
											}
									echo'</div><div class="list-group-item">
											<u>Tutor:</u>&nbsp;<br>';
											$TutorResult = mysqli_query($con,"SELECT StaffID FROM jobs WHERE Role='Tutor' AND Course='".$course['Name']."'");						
											while($tutor = mysqli_fetch_array($TutorResult))
											{
												$r = mysqli_query($con,"SELECT * FROM staff WHERE StaffID='".$tutor['StaffID']."'");				
												while($l = mysqli_fetch_array($r))
												{
													if($user == "ADMINS001" or $admin == 1)
													{
														echo '<div class="btn btn-default"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" onclick="deleteRole(\''.$tutor['StaffID'].'*'.$course['Name'].'*Tutor\')">×</button>'.$l['name'].'&nbsp;</div><br>';
													}
													else
													{
														echo '<li>'.$l['name'].'</li>';
													}
												}
											}
											echo'</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="list-group">
											<h4 class="list-group-item">List of Tests:</h4><div class="list-group-item">';
											$TestResult = mysqli_query($con,"SELECT Name FROM test WHERE Course='".$course['Name']."'");						
											while($test = mysqli_fetch_array($TestResult))
											{
												echo '<li>'.$test['Name'].'</li>';
											}
									
											
									echo'	</div></div>
									</div>
									</div>
									</div>
									</div>';
							}
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
	function deleteRole(value)
	{
		var xmlhttp=new XMLHttpRequest();
		  xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			  //document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
			  //alert(xmlhttp.responseText);
			}
		  }
		  xmlhttp.open("GET","UpdateRole.php?q="+value,true);
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
