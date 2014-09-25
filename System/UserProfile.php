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
    <title></title>

    <!-- Core CSS - Include with every page -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Page-Level Plugin CSS - Panels and Wells -->

    <!-- SB Admin CSS - Include with every page -->
    <link href="css/sb-admin.css" rel="stylesheet">
	<link href="css/datepicker.css" rel="stylesheet">
	
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
	  xmlhttp.open("GET","QuestionType.php?q="+str,true);
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
								$user = $_REQUEST["q"];
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
                    
					<?php echo '<input type=hidden id=user value='.$user.'>';
					echo '<h1 class="page-header">'.$user.'\'s Profile</h1><input type="hidden" value="'.$user.'" id="user"';?>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            
            <!-- /.row -->
            <div class="row">
				
                <div class="col-lg-12">
                  
					<!-- .panel-heading -->
					<div class="panel-body">
						<div id="notification"></div>
							<table>
							<?php 
								$url = "nightmare.cs.uct.ac.za:3306";
															
								
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
								$Name = mysqli_query($con,"SELECT * FROM staff WHERE StaffID='".$user."'");	
								while($row = mysqli_fetch_array($Name))
								{
									echo '<tr><td><Label>Name: &nbsp;</Label></td>
										<td><input name="Name" id="Name"class="form-control" value="'.$row['name'].'"></td><td>&nbsp;<button type="submit" class="btn btn-default" onclick="update()">Update</button></td></tr></table>';
								}
								//Display roles
								echo '<div class="col-lg-6"><br>
										<div class="panel panel-default">
											<div class="panel-heading">
												Assigned Roles
											</div>
											<!-- /.panel-heading -->
											<div class="panel-body">
												<div class="table-responsive">
													<table class="table table-hover">
														<thead>
															<tr>
																<th>Course</th>
																<th>Role</th>
															   
															</tr>
														</thead>
														<tbody>
															';
														
															$Jobs= mysqli_query($con,"SELECT * FROM jobs WHERE StaffID='".$user."'");	
															while($rows = mysqli_fetch_array($Jobs))
															{
															
															echo '<tr><td>'.$rows['Course'].'</td><td>'.$rows['Role'].'</td></tr>';
															}
														
														echo'
														</tbody>
													</table>
												</div>
												<!-- /.table-responsive -->
											</div>
											<!-- /.panel-body -->
										</div>
										<!-- /.panel -->
									</div>';
									echo '<div class="col-lg-6"><br>
										<div class="panel panel-default">
											<div class="panel-heading">
												Change Password
											</div>
											<!-- /.panel-heading -->
											<div class="panel-body">
											
											<table><tr><td><Label>Current Password: &nbsp;</Label></td>
											<td><input type="Password" id="CurrentPassword" class="form-control"><br></td></tr>
											<tr><td><Label>New Password: &nbsp;</Label></td>
											<td><input type="Password" id="NewPassword" class="form-control"><br></td></tr>
											<tr><td><Label>Confirm New Password: &nbsp;</Label></td>
											<td><input type="Password" id="ConfirmPassword" class="form-control" onChange="checkPasswordMatch()"><br></td></tr>
											<tr><td><div class="registrationFormAlert" id="divCheckPasswordMatch"></div></td></tr>
											<tr><td></td><td>&nbsp;<button type="submit" class="btn btn-default" onclick="changePassword()">Change Password</button></td></tr></table>
											
											</div></div></div>';
											
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
	</script>
    <!-- Core Scripts - Include with every page -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.min.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <!-- Page-Level Plugin Scripts - Panels and Wells -->
	<script type="text/javascript">
           function update()
		   {
					var info = document.getElementById("user").value+"-"+document.getElementById("Name").value;
					var xmlhttp=new XMLHttpRequest();
					xmlhttp.onreadystatechange=function() {
					if (xmlhttp.readyState==4 && xmlhttp.status==200) {
					  document.getElementById("notification").innerHTML=xmlhttp.responseText;
					  //alert("done");
					}
				  }
				  xmlhttp.open("GET","NameUpdate.php?q="+info,true);
				  xmlhttp.send();
			}
		function checkPasswordMatch() 
		{
			var password = $("#NewPassword").val();
			var confirmPassword = $("#ConfirmPassword").val();

			if (password != confirmPassword)
				$("#divCheckPasswordMatch").html("Passwords do not match!");
			else
				$("#divCheckPasswordMatch").html("Passwords match.");
		}

		$(document).ready(function () {
		   $("#txtConfirmPassword").keyup(checkPasswordMatch);
		});
				   
		function changePassword()
		{
			if((document.getElementById("NewPassword").value).match(/\s/g))
			{
				alert("Your passwaord may not have a space.");
			}
			else
			{
			if(document.getElementById("NewPassword").value == document.getElementById("ConfirmPassword").value)
			{
			var info = document.getElementById("user").value+"+"+document.getElementById("CurrentPassword").value;
			var xmlhttp=new XMLHttpRequest();
			xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
				var response = xmlhttp.responseText;
					
					if(response == 1)
					{
						change();						
					}
					else
					{
						alert(response);
					}
				}
				}
			  xmlhttp.open("GET","loginCheck.php?q="+info,true);
			  xmlhttp.send();
			}
			}
		}
	function change()
	{
		var info = document.getElementById("user").value+" "+document.getElementById("NewPassword").value;
		var xmlhttp=new XMLHttpRequest();
				xmlhttp.onreadystatechange=function() {
				if (xmlhttp.readyState==4 && xmlhttp.status==200) {
				  document.getElementById("notification").innerHTML=xmlhttp.responseText;
				  //alert("done");
				}
			  }
			  xmlhttp.open("GET","ChangePassword.php?q="+info,true);
			  xmlhttp.send();
	}
        </script>
    <!-- SB Admin Scripts - Include with every page -->
    <script src="js/sb-admin.js"></script>

    <!-- Page-Level Demo Scripts - Panels and Wells - Use for reference -->

</body>

</html>
