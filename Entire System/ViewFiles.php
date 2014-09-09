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
										
										// login with username and password
										//$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
										/*$connection = ssh2_connect('nightmare.cs.uct.ac.za', 22);
										$sftp = ssh2_sftp($connection);

										if (ssh2_auth_password($connection, 'zmathews', '800hazhtM')) {
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
										
										// When a course is added
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
												
												//add to database
												//$AddCourse = "INSERT INTO course VALUES ('$_POST[Course]','$_POST[Convenor]','$_POST[TA]',0)";
												//mysql_query($AddCourse) or die(mysql_error());
												$AddCourse ="INSERT INTO course VALUES ('$_POST[Course]','$_POST[Convenor]','$_POST[TA]',0)";
												mysqli_query($con, $AddCourse);
												
												
												//create folder 
												//$cmd =  "mkdir ".$dir;
												 mkdir($dir);
												//ssh2_exec($connection,$cmd);
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
											//echo $_POST['Local']."<br>";
											//echo $_POST['Remote']."<br>";
											//ssh2_scp_send($connection,$_POST['Local'],$_POST['Remote'],0644);
											$AddQuery ="INSERT INTO script (StudentNumber, Course, Test, Mark) 
											VALUES
											('$_POST[studentNumber]','$_POST[Course]','$_POST[Test]',$_POST[Mark])";
											mysqli_query($con, $AddQuery);
										}
										if(isset($_POST['SubmitTest']))
										{
											//create test folder [WORKS]
											//upload memo to folder [WORKS]
											//insert info in DB [WORKS]
											
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
												VALUES ('$_POST[Test]','$_POST[Course]',$_POST[TestID],$_POST[NumQuestions], '$QuestionType', Date )";
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
										
										//Create file view
										$countCourse = 1;
										$labelOne = '"panel panel-default"';
										$labelTwo =  '"panel-collapse collapse"';
																				
																			
										//$courseNames = "SELECT Name FROM course";
										//$resultCourseNames = mysql_query($courseNames)or die(mysql_error());
										$courseNames = mysqli_query($con,"SELECT Name FROM course");						
										while($row = mysqli_fetch_array($courseNames))
										{
											$Course = $row['Name'];
											//echo $Course.'<br>';
											//one accordion
												echo "<div class=".$labelOne.">";
												echo "<div class=panel-heading>";
												echo "<h4 class=panel-title>";
												echo "<a data-toggle=collapse data-parent=#accordion href=#collapse".$countCourse.">".$Course."</a>";
												echo "</h4>";
												echo "</div>";
												echo "<div id=collapse".$countCourse." class=".$labelTwo.">";
												echo "<div class=panel-body>";
												
												//$testNames = "SELECT Name FROM test WHERE Course='".$Course."'";
												//$resultTestNames = mysql_query($testNames)or die(mysql_error());
											
												
													//while($row2 = mysql_fetch_array($resultTestNames, MYSQL_ASSOC))
													$testNames  = mysqli_query($con,"SELECT Name FROM test WHERE Course='".$Course."'");						
													while($row2 = mysqli_fetch_array($testNames))
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
															
															//$output = shell_exec("ls /home/zmathews/Honours_Project/".$Course."/".str_replace(" ","_",$Test)."/");
															foreach (glob("Files/".$Course."/".str_replace(" ","_",$Test)."/*") as $name) 
															{
																if(is_dir($name))
																{
																	$name = explode("/", $name);
																	echo '<a href="Editor.php?q=/'.$Course.'/'.str_replace(" ","_",$Test).'/'.$name[3].'/page2.png" onclick="checkFiles("'.$Course.'/'.str_replace(" ","_",$Test).'/'.$name[3].'")">'.$name[3].'</a><br>';
																	
																}
															}
															/*$FileName = explode("+", $output);
															$size = sizeof($FileName); 
															foreach($FileName as $name)

															{	
                                                                //echo '<a href="Editor.php?q=/'.$Course.'/'.str_replace(" ","_",$Test).'/'.$name.'/page2.png" onclick="checkFiles("'.$name.'")">'.$name.'</a><br>';
                                                           
															}*/

															echo "</div>";
															echo "</div>";
															echo "</div>";
														
													
													}
												
												echo "</div>";
												echo "</div>";
												echo "</div>";
												
												
												$countCourse = $countCourse +1;
									
										}
											
		
										/*while($row = mysql_fetch_array($resultCourseNames, MYSQL_ASSOC))
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
															

															
															$FileName = explode("+", $output);
															$size = sizeof($FileName); 
															foreach($FileName as $name)

															{	
                                                                                                                echo '<a href="Editor.php?q=/'.$Course.'/'.str_replace(" ","_",$Test).'/'.$name.'/page2.png" onclick="checkFiles("'.$name.'")">'.$name.'</a><br>';
                                                           
															}

															echo "</div>";
															echo "</div>";
															echo "</div>";
														
													
													}
												
												echo "</div>";
												echo "</div>";
												echo "</div>";
												
												
												$countCourse = $countCourse +1;
									
										}*/
											
										//mysql_close($con);
											mysqli_close($con);										
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

		<script>
	function checkFiles(str) {
	  
	  var xmlhttp=new XMLHttpRequest();
	  xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		  //document.getElementById("mark").innerHTML=xmlhttp.responseText;
		}
	  }
	  xmlhttp.open("GET","fileCreation.php?q="+str,true);
	  xmlhttp.send();
	 
	}
	</script>

    <!-- Page-Level Demo Scripts - Panels and Wells - Use for reference -->

</body>

</html>
