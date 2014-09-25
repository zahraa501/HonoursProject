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
    <title>Add A Script</title>

    <!-- Core CSS - Include with every page -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Page-Level Plugin CSS - Panels and Wells -->

    <!-- SB Admin CSS - Include with every page -->
	<link rel="stylesheet" type="text/css" media="all" href="css/styles.css" />
    <link href="css/sb-admin.css" rel="stylesheet">
	
	<script>
	function populateDropdown(str) {
	  if (str.length==0) {
		document.getElementById("Test").innerHTML="";
		return;
	  }
	  var xmlhttp=new XMLHttpRequest();
	  xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		  document.getElementById("Test").innerHTML=xmlhttp.responseText;
		}
	  }
	  xmlhttp.open("GET","TestDropdown.php?q="+str,true);
	  xmlhttp.send();
	}
	</script>
	
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
                <a class="navbar-brand" href="Home.php<?php echo '?q='.$_REQUEST["q"];?>">Demo</a>
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
                    <h1 class="page-header">Scripts</h1>
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
							echo '<li>
								<a href="CourseInformation.php?q='.$user.'">View Course Information</a>
							</li>';
							if($Type == "Admin")
							{
							echo'<li><a href="AddCourse.php?q='.$user.'">Add a Course</a></li>';
							}
							if($Type != "Tutor")
							echo '<li>
								<a href="AddTest.php?q='.$user.'">Add a Test</a>
							</li>';
							echo'<li class="active">
								<a>Add a Script</a>
							</li>';
							echo'<li>
								<a href="AddStudents.php?q='.$user.'">Add Students</a>
							</li>';
						?>
						</ul> <br>
						
						<form id="upload" action="CourseInformation.php<?php echo '?q='.$user;?>" method="POST" enctype="multipart/form-data">
						
						<table>
							<form>
						
							
							<?php
								//echo '<option>Mark</option><option>Sally</option><option>Tim</option>'
				
										$url = "nightmare.cs.uct.ac.za:3306";
										// login with username and password
										//$connection = ssh2_connect('nightmare.cs.uct.ac.za', 22);
										//$sftp = ssh2_sftp($connection);

										/*if (ssh2_auth_password($connection, 'zmathews', '800hazhtM')) {
									  	//echo "Authentication Successful!\n";


										} else {
										  die('Authentication Failed...');
										}*/
										
										// Connect to DB
											//$con = mysql_connect($url,"zmathews","quohfeex","zmathews");
											$con=mysqli_connect("localhost:3306","root","Changmin88","honours_project");
										// Check connection
										if (!$con) 
										{
											echo "<div class=".$redAlert.">";
											echo "Failed to connect to MySQL (".$url."): " . mysql_error();
											echo "</div>";

										}
										//specify table
										//mysql_select_db('zmathews');
										
									//query for course names
									/*$selectQueryCourse = "SELECT Name FROM course";
									$resultCourses = mysql_query($selectQueryCourse)or die(mysql_error());
									
									//populate dropdown options
									while($courses = mysql_fetch_array($resultCourses, MYSQL_ASSOC))
								{
									$CourseName = $courses['Name'];
									echo '<option value='.$CourseName.'>'.$CourseName.'</option>';
								}*/
								echo '<tr><th><Label>Course:</Label></th>';
								echo '<th><select name="Course" class="form-control" onChange="populateDropdown(this.value)">';
								$result = mysqli_query($con,"SELECT Name FROM course");						
								while($courses = mysqli_fetch_array($result))
								{
									$CourseName = $courses['Name'];
									echo '<option value='.$CourseName.'>'.$CourseName.'</option>';
								}
								
							
								
								
							
							echo '</select></th></tr>';
							echo '</form>';
							echo '<tr><th>&nbsp;</th><th>&nbsp;</th></tr>';
							echo '<tr><th><Label>Test:</Label></th>';
							echo '<th><span id=Test>';
							echo '<select name=Test  class=form-control>';
                                    
								/*//query for test names
									$selectQueryTest = "SELECT Name FROM test WHERE Course='CSC1010H'";
									$resultTest = mysql_query($selectQueryTest)or die(mysql_error());
									
									//populate dropdown options
									while($test = mysql_fetch_array($resultTest, MYSQL_ASSOC))
								{
									$TestName = $test['Name'];
									echo '<option value="'.$TestName.'">'.$TestName.'</option>';
								}*/
								$selectQueryTest = mysqli_query($con,"SELECT Name FROM test WHERE Course='CSC1010H'");						
								while($test= mysqli_fetch_array($selectQueryTest))
								{
									$TestName = $test['Name'];
									echo '<option value="'.$TestName.'">'.$TestName.'</option>';
								}
								
								echo '</select></div></th></tr>';

                            echo '</select></span>';
							
							mysqli_close($con);
							?>
							</th></tr>
						</table>
							<br>
							

							<div>
								<label>Files to upload:</label>
								<input type="file" name="file" id="file" class="btn btn-default"/>
								<!--<div id="filedrag">or drop files here</div>-->
							</div>
							<br>
							<button name="Upload" type="submit" class="btn btn-default">Upload Files</button>
						</form>
						
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
	<script src="js/filedrag.js"></script>
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <!-- Page-Level Plugin Scripts - Panels and Wells -->

    <!-- SB Admin Scripts - Include with every page -->
    <script src="js/sb-admin.js"></script>

    <!-- Page-Level Demo Scripts - Panels and Wells - Use for reference -->

</body>

</html>
