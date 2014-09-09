<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Demo</title>

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

<body>

    <div id="wrapper">

        <nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">Demo</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>Read All Messages</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-messages -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-tasks fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-tasks">
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 1</strong>
                                        <span class="pull-right text-muted">40% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                            <span class="sr-only">40% Complete (success)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 2</strong>
                                        <span class="pull-right text-muted">20% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                                            <span class="sr-only">20% Complete</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 3</strong>
                                        <span class="pull-right text-muted">60% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                            <span class="sr-only">60% Complete (warning)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 4</strong>
                                        <span class="pull-right text-muted">80% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                            <span class="sr-only">80% Complete (danger)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>See All Tasks</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-tasks -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-comment fa-fw"></i> New Comment
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                    <span class="pull-right text-muted small">12 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-envelope fa-fw"></i> Message Sent
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-tasks fa-fw"></i> New Task
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>See All Alerts</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-alerts -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="login.html"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default navbar-static-side" role="navigation">
                <div class="sidebar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li>
                            <a href="index.html"><i class="fa fa-dashboard fa-fw"></i> Home</a>
                        </li>
                        <li>
                            <a href="ViewFiles.php"><i class="fa fa-edit fa-fw"></i> Scripts<span class="fa arrow"></a>
							<ul class="nav nav-second-level">
                                <li>
                                    <a href="ViewFiles.php">View Scripts</a>
                                </li>
                                <li>
                                    <a href="AddCourse.php">Add a Course</a>
                                </li>
                                <li>
                                    <a href="#">Add a Test</a>
                                </li>
                                <li>
                                    <a href="AddScript.php">Add a Script</a>
                                </li>
                            </ul>
                        </li>
						<li>
                            <a href="tables.html"><i class="fa fa-table fa-fw"></i> Tables</a>
                        </li>
						<li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Dashboard</span></a>
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
                    <h1 class="page-header">Add a Test</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            
            <!-- /.row -->
            <div class="row">
				
                <div class="col-lg-12">
                  
					<!-- .panel-heading -->
					<div class="panel-body">
						<ul class="nav nav-pills">
							<li><a href="ViewFiles.php">View Scripts</a>
							</li>
							<li><a href="AddCourse.php">Add a Course</a>
							</li>
							<li class="active"><a href="#">Add a Test</a>
							</li>
							<li><a href="AddScript.php">Add a Script</a>
							</li>
						</ul> <br>
						
						
						<form id="upload" action="ViewFiles.php" method="POST" enctype="multipart/form-data">
							<table>
							<?php 
							$url = "nightmare.cs.uct.ac.za:3306";
							
								// set up basic connection
								$conn_id = ftp_connect($ftp_server);

								// login with username and password
								$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
								
								// Connect to DB
											$con = mysql_connect($url,"zmathews","quohfeex","zmathews");
	
								// Check connection
								if (!$con) 
								{
									echo "<div class=".$redAlert.">";
									echo "Failed to connect to MySQL (".$url."): " . mysql_error();
									echo "</div>";

								}
								//specify table
								mysql_select_db('zmathews');
								
														
								//create dropdown for courses
								echo '<tr><th><Label>Course:</Label></th><th><div class=form-group><select name=Course class=form-control>';
								
								//query for course names
								$selectQueryCourse = "SELECT Name FROM course";
								$resultCourses = mysql_query($selectQueryCourse)or die(mysql_error());
		
								//populate dropdown options
								while($courses = mysql_fetch_array($resultCourses, MYSQL_ASSOC))
								{
									$CourseName = $courses['Name'];
									echo '<option value='.$CourseName.'>'.$CourseName.'</option>';
								}
								echo '</select></div></th></tr>';
								
								//count tests
								$selectQueryNoTests = "SELECT COUNT(*) AS number FROM test";
								$resultNoTests = mysql_query($selectQueryNoTests)or die(mysql_error());
								
								//this will be the ID of test
								while($count = mysql_fetch_array($resultNoTests, MYSQL_ASSOC))
								{
									$NumTests = $count['number'];
								}
								$NumTests = $NumTests +1;
							mysql_close($con);
							ftp_close($conn_id);
							?>
							<tr><td><Label>New Test: &nbsp;</Label></td>
							<td><input name="Test" class="form-control"><br></td></tr>
							
							<tr><td><Label>Date to Mark By: &nbsp;</Label></td>
							<td><div class="form-group input-group"><input name="Date" type="text" data-date-format="dd-mm-yyyy" class="datepicker"><span class="input-group-addon"><img src='datepicker.png'/></span></div></td></tr>
							
							<tr><td><Label>Number of Questions: &nbsp;</Label></td>
							<td><input name="NumQuestions" type="number" min="1" value="1" class="form-control" onChange="populateDropdown(this.value)"><br></td></tr>
							<tr>
							<td colspan="2"><div class="panel panel-default" >
								<div class="panel-heading">Type of Questions:</div>
								<span id=Test>
									<div class=""table-responsive><table class="table"><tbody><tr><th>Question 1</th><th><select class="form-control" name="q1"><option value=knowledge>Knowledge</option><option value=comprehension>Comprehension</option><option value=Application>Application</option><option value=analysis>Analysis</option><option value=synthesis>Synthesis</option><option value=evaluation>Evaluation</option></select></th>
									</tr></tbody></table></div>
								
								</span>
							</div></td>
							
							</tr>
							<tr><td><Label>Memorandumn:</Label></td><td><input type="file" name="file" id="file" class="btn btn-default"/></td></tr>
							</table>
								
							<br>
							<?php echo '<input type=hidden name=TestID value="'.$NumTests.'">';?>
							<input type="submit" name="SubmitTest" value="Add" class="btn btn-default">
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

    <!-- Core Scripts - Include with every page -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.min.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <!-- Page-Level Plugin Scripts - Panels and Wells -->
	<script type="text/javascript">
            $('.datepicker').datepicker();
        </script>
    <!-- SB Admin Scripts - Include with every page -->
    <script src="js/sb-admin.js"></script>

    <!-- Page-Level Demo Scripts - Panels and Wells - Use for reference -->

</body>

</html>
