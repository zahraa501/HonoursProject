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
	<script src="jquery.js"></script>
	<script src="jquery.annotate.js"></script>
	<link rel="stylesheet" type="text/css" href="demo.css">
	

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
			<br>
				<!--<div class="btn-toolbar" role="toolbar">
				  <div class="btn-group">
					<button type="button" class="btn btn-default"><span class="glyphicon glyphicon-ok"></span></button>
					<button type="button" class="btn btn-default"><span> <img src='half-tick.png' width="15px" height="15px"/></span></button>
					<button type="button" class="btn btn-default"><span class="glyphicon glyphicon-repeat"></span></button>
					<button type="button" class="btn btn-default"><span class="glyphicon glyphicon-flag"></span></button>
				  </div>
				</div>-->
				<div class="col-lg-6">
					<form role=form>
					<label>Student Number:</label>
					<input class="form-control" name="studentNumber">
					<p>Please have a look at the image below and insert the student number found.</p>
					</form>
					<div class="well">
					<?php 
						$dir = str_replace(" ","+", $_GET["directory"]);
						echo '<img src="uploads/'.$dir.'/page1.png" width="100%"/>';
						
						//with the input button SQL statement to db need to be added.
					?>
					
                    </div>
					<input type="submit" href="save.php" class="btn btn-outline btn-primary btn-lg btn-block" value="Complete">
			  
				</div>
				</div>
				</div>
				</div>
	    <!-- Core Scripts - Include with every page -->
		 <script src="js/bootstrap.min.js"></script>
		 <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    
    <!-- Page-Level Plugin Scripts - Panels and Wells -->

    <!-- SB Admin Scripts - Include with every page -->
    <script src="js/sb-admin.js"></script>
	

	
	</body>
</html>