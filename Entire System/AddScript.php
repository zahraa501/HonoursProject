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
                                    <a href="AddTest.php">Add a Test</a>
                                </li>
                                <li>
                                    <a href="#">Add a Script</a>
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
                    <h1 class="page-header">Scripts</h1>
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
							<li><a href="AddTest.php">Add a Test</a>
							</li>
							<li class="active"><a href="#">Add a Script</a>
							</li>
						</ul> <br>
						
						<form id="upload" action="ViewFiles.php" method="POST" enctype="multipart/form-data">
						
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
