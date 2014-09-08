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
	<script>
	function downloadFile(str) {
	  if (str.length==0) {
		document.getElementById("File").innerHTML="";
		return;
	  }
	  var xmlhttp=new XMLHttpRequest();
	  xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		  document.getElementById("File").innerHTML=xmlhttp.responseText;
		}
	  }
	  xmlhttp.open("GET","Editor.php?q="+str,true);
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
                            <a href="#"><i class="fa fa-edit fa-fw"></i> Scripts<span class="fa arrow"></a>
							<ul class="nav nav-second-level">
                                <li>
                                    <a href="#">View Scripts</a>
                                </li>
                                <li>
                                    <a href="AddCourse.php">Add a Course</a>
                                </li>
                                <li>
                                    <a href="AddTest.php">Add a Test</a>
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
                    <h1 class="page-header">Computer Science Courses</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            
            <!-- /.row -->
            <div class="row">
				
                <div class="col-lg-12">
                  
					<!-- .panel-heading -->
					<div class="panel-body">
						<ul class="nav nav-pills">
							<li class="active"><a href="#" >View Scripts</a>
							</li>
							<li><a href="AddCourse.php">Add a Course</a>
							</li>
							<li><a href="AddTest.php">Add a Test</a>
							</li>
							<li><a href="AddScript.php">Add a Script</a>
							</li>
						</ul> <br>
							
						
                            <div class="panel-group" id="accordion">
							
							<span id=File></span>
									<?php 
										$url = "nightmare.cs.uct.ac.za:3306";
										$greenAlert = '"alert alert-success"';
										$redAlert = '"alert alert-danger"';
										
										// set up basic connection
										$conn_id = ftp_connect($ftp_server);

										// login with username and password
										//$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
										$connection = ssh2_connect('nightmare.cs.uct.ac.za', 22);
										$sftp = ssh2_sftp($connection);

										if (ssh2_auth_password($connection, 'zmathews', '800hazhtM')) {
									  	//echo "Authentication Successful!\n";


										} else {
										  die('Authentication Failed...');
										}
										
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
										
										// When a course is added
										if(isset($_POST['Submit']))
										{	
											//add condition
											$addCourse = 0;
											$checkCourse = "SELECT * FROM course WHERE Name='".$_POST['Course']."'";
											$resultCheck = mysql_query($checkCourse)or die(mysql_error());
											while($row = mysql_fetch_array($resultCheck, MYSQL_ASSOC))
											{
												$addCourse = $addCourse +1;
											}

											//makes sure directory has no whitespaces
											$dir = "/home/zmathews/Honours_Project/".str_replace(" ","_",$_POST['Course']);
										
											//if folder doesn't exist
											if($addCourse == 0)
											{
												
												//add to database
												$AddCourse = "INSERT INTO course VALUES ('$_POST[Course]','$_POST[Convenor]','$_POST[TA]',0)";
												mysql_query($AddCourse) or die(mysql_error());
												//create folder 
												$cmd =  "mkdir ".$dir;

												ssh2_exec($connection,$cmd);
												//ftp_mkdir($connection, $dir);
												//success message
												echo "<div class=".$greenAlert.">";
												echo $_POST['Course']." was successfully added.</div>";
												
												
											}
											//if folder does exist
											else
											{
												echo "<div class=".$redAlert.">";
												echo $_POST['Course']." could not be added.</div>";
											}												
										}
										if(isset($_POST['Complete']))
										{
											
											ssh2_scp_send($connection,$_POST['Local'],$_POST['Remote'],0644);
										}
										if(isset($_POST['SubmitTest']))
										{
											//create test folder [WORKS]
											//upload memo to folder [WORKS]
											//insert info in DB [WORKS]
											
											//check if course exists
											$addTest = 0;
											$checkCourse = "SELECT * FROM course WHERE Name='".$_POST['Course']."'";
											$resultCheck = mysql_query($checkCourse)or die(mysql_error());
											while($row = mysql_fetch_array($resultCheck, MYSQL_ASSOC))
											{
												$addTest = $addTest +1;
											}
											
											
											if($addTest == 1)
											{
												
												//directory of test
												$dir = $_POST['Course'].'/'.str_replace(" ","_",$_POST['Test']);
												
												//create test folder
												$cmd =  "mkdir /home/zmathews/Honours_Project/".$dir;
												ssh2_exec($connection,$cmd);
												
												//ftp_mkdir($conn_id, $dir);
												
												if ($_FILES["file"]["error"] > 0) 
												{
													echo "<div class=".$redAlert.">";
													echo "Error: " . $_FILES["file"]["error"] . "</div><br>";
												} 
												else 
												{
													
													$dest_file = '/home/zmathews/Honours_Project/'.str_replace(" ","_",$_POST['Course']).'/'.str_replace(" ","_",$_POST['Test']).'/'.$_FILES["file"]["name"];
															
													ssh2_scp_send($connection,$_FILES["file"]["tmp_name"],$dest_file,0644);

												}
												
												//Question type that will be inserted in DB
												$QuestionType = "";
												
												for($x=1; $x<=$_POST['NumQuestions']; $x++)
												{	
													$ref = "q".$x;
													$QuestionType = $QuestionType.'+'.$_POST[$ref];
												}
												
												//add to database
												$AddTest = "INSERT INTO test (Name,Course,testID,NumberOfQuestions,TypeOfQuestions,Date)	VALUES ('$_POST[Test]','$_POST[Course]',$_POST[TestID],$_POST[NumQuestions], '$QuestionType', Date )";
												mysql_query($AddTest) or die(mysql_error());
																					
												
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
												if ($_FILES["file"]["error"] > 0) 
												{
													echo "<div class=".$redAlert.">";
													echo "Error: " . $_FILES["file"]["error"] . "</div><br>";
												} 
												else 
												{
													
													$dest_file = '/home/zmathews/Honours_Project/'.str_replace(" ","_",$_POST['Course']).'/'.str_replace(" ","_",$_POST['Test']).'/'.$_FILES["file"]["name"];
															
													ssh2_scp_send($connection,$_FILES["file"]["tmp_name"],$dest_file,0644);

												}

												
										}
										
										//Create file view
										$countCourse = 1;
										$labelOne = '"panel panel-default"';
										$labelTwo =  '"panel-collapse collapse"';
																				
																			
										$courseNames = "SELECT Name FROM course";
										$resultCourseNames = mysql_query($courseNames)or die(mysql_error());
		
										while($row = mysql_fetch_array($resultCourseNames, MYSQL_ASSOC))
										{
				
											$Course = $row['Name'];
											
											//one accordion
												echo "<div class=".$labelOne.">";
												echo "<div class=panel-heading>";
												echo "<h4 class=panel-title>";
												echo "<a data-toggle=collapse data-parent=#accordion href=#collapse".$countCourse.">".$Course."</a>";
												echo "</h4>";
												echo "</div>";
												echo "<div id=collapse".$countCourse." class=".$labelTwo.">";
												echo "<div class=panel-body>";
												
												$testNames = "SELECT Name FROM test WHERE Course='".$Course."'";
												$resultTestNames = mysql_query($testNames)or die(mysql_error());
											
												
													while($row2 = mysql_fetch_array($resultTestNames, MYSQL_ASSOC))
													{
														$Test = $row2['Name'];
											
														$countCourse = $countCourse +1;
														
														
															//one accordion
															echo "<div class=".$labelOne.">";
															echo "<div class=panel-heading>";
															echo "<h4 class=panel-title>";
															echo "<a data-toggle=collapse data-parent=#accordionAssignment href=#collapseAssignment".$countCourse.">".$Test."</a>";
															echo "</h4>";
															echo "</div>";
															echo "<div id=collapseAssignment".$countCourse." class=".$labelTwo.">";
															echo "<div class=panel-body>";

															$output = shell_exec("ls /home/zmathews/Honours_Project/".$Course."/".str_replace(" ","_",$Test)."/");
															

															
															$FileName = explode(".", $output);
															$size = sizeof($FileName); 
															foreach($FileName as $name)
															{	$size = $size -1;
																$name= str_replace("txt","",$name);
																$name= str_replace("pdf","",$name);
																if($size != 0)
																{
																	//$d = "/".$Course."/".str_replace(" ","_",$Test)."/";
																	if(strpos($output, $name.".pdf")!== false)
																	{

																		echo '<a href="Editor.php?q=/'.$Course.'/'.str_replace(" ","_",$Test).'/'.$name.'.pdf">'.$name.'.pdf</a><br>';
																	}
																	else
																	{
																		echo '<a href="Editor.php?q=/'.$Course.'/'.str_replace(" ","_",$Test).'/'.$name.'.txt")>'.$name.'.txt</a><br>';
																	}
																}
															}

															echo "</div>";
															echo "</div>";
															echo "</div>";
														
													
													}
												
												echo "</div>";
												echo "</div>";
												echo "</div>";
												
												
												$countCourse = $countCourse +1;
									
										}
											
										mysql_close($con);
																					
									?>
                                              	
							</div> 
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
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <!-- Page-Level Plugin Scripts - Panels and Wells -->

    <!-- SB Admin Scripts - Include with every page -->
    <script src="js/sb-admin.js"></script>

    <!-- Page-Level Demo Scripts - Panels and Wells - Use for reference -->

</body>

</html>
