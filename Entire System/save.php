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
	<script src="js/jquery.js"></script>
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

                <a class="navbar-brand" href="#"><i class="glyphicon glyphicon-pencil"></i>&nbsp;Editor</a>
				
            </div>
            <!-- /.navbar-top-links -->


            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div class="container"  style="width: 100%;">
          <br>
			<div class="row">
                <div class="col-lg-5">
				
					
					<div class="well">
					<?php 
						$info = explode("/",$_GET["directory"]);
						
						$course = $info[1];
						$test = $info[2]; 
						$dir = str_replace(" ","+",$info[3]);
						echo '<img src="Files/'.$course.'/'.$test.'/'.$dir.'/page1.png" width="100%"/>';
						
						
					?>
					
                    </div>
					
					</div>
			
				<div class="col-lg-5">
					<form name="input" action="ViewsFiles.php" method="post">
					<label>Student Number:</label>
					<input type="text" class="form-control" name="studentNumber">
					<p>Please insert the student number found on the image.</p>
					<?php 
					$course = explode("CSC",$course);
					
					echo '<div class="form-group">
						<label for="disabledSelect">Course</label>
						<input class="form-control" id="disabledInput" type="text" value="CSC'.$course[1].'"placeholder="Disabled input" disabled="">
					</div>';
					echo '<div class="form-group">
						<label for="disabledSelect">Test</label>
						<input class="form-control" id="disabledInput" type="text"  value="'.str_replace("_", " ", $test).'"placeholder="Disabled input" disabled="">
					</div>';
					
					$mark = file_get_contents('Files/CSC'.$course[1].'/'.$test.'/'.$dir."/marks.txt");
					$mark = str_replace("This is the marks for: ".str_replace("/","",$info[3]),"",$mark);
					$content = file_get_contents('Files/CSC'.$course[1].'/'.$test.'/reformattedEndMarkers.txt');
					$content = explode("<split_marker>",$content);
					$total = explode(" ",$content[0]);
					echo '<div class="form-group">
						<label for="disabledSelect">Mark</label>
						<input class="form-control" id="disabledInput" type="text" value="'.$mark.'/'.str_replace("Question", "", $total[0]).'"placeholder="Disabled input" disabled="">
					</div>';
					
					echo '<input type="hidden" name="Course" "CSC'.$course[1].'">';
					echo '<input type="hidden" name="Test" value="'.str_replace("_", " ", $test).'">';
					echo '<input type="hidden" name="Mark" value="'.str_replace(" ","",$mark).'">';
					?>
					
					<input type="submit" class="btn btn-outline btn-success btn-lg btn-block" name="Complete" value="Complete">
					</form>
				</div>
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