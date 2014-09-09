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

<body onload="checkFiles()">

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
		<?php
			$con=mysqli_connect("localhost:3306","root","Changmin88","honours_project");
			// Check connection
			if (!$con) 
			{
			  echo "Failed to connect to MySQL: " . mysql_error();
			}
			if(isset($_POST['Complete']))
			{
				$AddQuery ="INSERT INTO script (StudentNumber, Course, Test, Mark) 
				VALUES
				('$_POST[studentNumber]','$_POST[Course]','$_POST[Test]',$_POST[Mark])";
				mysqli_query($con, $AddQuery);
			}
			$result = mysqli_query($con,"SELECT * FROM script");						
			while($row = mysqli_fetch_array($result))
			{
				echo $row['StudentNumber'].' '.$row['Course'].' '.$row['Test'].' '.$row['Mark'].'<br>';
			}
			mysqli_close($con);
		?>
            <div class="row">
			
			 <form action="Editor.php" method="post">
			 <?php $dir = "CSC1010H/Test_2/1-Class_Test_2-20140904_1244+/"; 
			 echo '<input type="hidden" id="directory" value="'.$dir.'">';?>
			 <div>
			  <ul class="pagination pagination-lg">
				<li><a href="#">«</a></li>
				<li><a href="Editor.php?q=<?php echo $dir ?>page2.png" onclick="checkFiles()">1</a></li>
				<li><a href="test.php?q=<?php echo $dir ?>page2.png" onclick="checkFiles()">2</a></li>
				<li><a href="#">3</a></li>
				<li><a href="#">4</a></li>
				<li><a href="#">5</a></li>
				<li><a href="#">»</a></li>
			  </ul>
			</div>
			 <input type="submit"/>
			 </form>
			 
            </div>
		</div>
	</div>
	    <!-- Core Scripts - Include with every page -->
		 <script src="js/bootstrap.min.js"></script>
		 <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    
    <!-- Page-Level Plugin Scripts - Panels and Wells -->

    <!-- SB Admin Scripts - Include with every page -->
    <script src="js/sb-admin.js"></script>
	<script>
	function checkFiles(str) {
	  str= document.getElementById("directory").value;
	  
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

	
	</body>
</html>