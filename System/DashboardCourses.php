<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php 
	$con=mysqli_connect("localhost:3306","root","Changmin88","honours_project");
	//Authentication Checks
	//checks if there is no StaffID
	if(isset($_REQUEST["q"])==0)
	{
		echo '<meta http-equiv="refresh" content="0; URL=http://localhost:8080/System/Login.php">';
	}
	else
	{
		$course = 'CSC1010H';
		$testName = 'Test 1';
		if(isset($_POST['courseSelect']) and isset($_POST['testSelect'])) {
			$course = $_POST['courseSelect'];
			$test = $_POST['testSelect'];
		}
		//Checks if StaffID is valid
		$Name = mysqli_query($con,"SELECT name, Type, LastLogin, LastLogout FROM staff WHERE StaffID='".$_REQUEST["q"]."'");	
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
		echo'<script> function loadpage(){$("body").show();loadGraphs();}</script>';
	}
	mysqli_close($con);	
	?>
	
    <title>Dashboard</title>
	<!-- Core CSS - Include with every page -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    
    <!-- Core CSS - Include with every page -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Page-Level Plugin CSS - Panels and Wells -->

    <!-- SB Admin CSS - Include with every page -->
    <link href="css/sb-admin.css" rel="stylesheet">
	 <!-- Calendar -->
	<link href='css/fullcalendar.css' rel='stylesheet' />
	<link href='css/fullcalendar.print.css' rel='stylesheet' media='print' />
	
</head>

<body onload="loadpage()">

    <div id="wrapper">

        <nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="Home.php?q=<?php echo $_REQUEST["q"];?>" class="navbar-brand">Demo</a>
				
            </div>
			
			 <ul class="nav navbar-top-links navbar-right">
				<li><font color="grey"><?php echo $name;?>
				</font></li>
				 <li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">
						<i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
					</a>
					<ul class="dropdown-menu dropdown-user">
						<li><a href="UserProfile.php?q=<?php  echo $_REQUEST["q"];?>"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
						<li class="divider"></li>
						<li><a href="Login.php" onclick="Logout()"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
						</li>
						<li></li>
					</ul>
						<!-- /.dropdown-user -->
                </li>
			</ul>
			
					
			 
            <!-- /.navbar-header -->
            <!-- /.navbar-top-links -->

            <div class="navbar-default navbar-static-side" role="navigation">
                <div class="sidebar-collapse">
				<ul class="nav" id="side-menu">
				
						
                        <li>
                            <a href="Home.php?q=<?php echo $_REQUEST["q"];?>"><i class="glyphicon glyphicon-home"></i> Home</a>
                        </li>
                        <li>
						<!-- Courses panel-->
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
								$user = $_REQUEST["q"];
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
						<!-- Admin panel-->
                            <a><i class="fa fa-edit fa-fw"></i>Administration<span class="fa arrow"><span></a>
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
			<div class="panel-group" id="testInformation">
				<div class="row" >
				<br>
					<?php 
						//db connection
						$con=mysqli_connect("localhost:3306","root","Changmin88","honours_project");
						//find out what courses are associated with account
						$adminRights = array();
						$rights = mysqli_query($con,"SELECT Course, Role FROM jobs WHERE StaffID='".$user."'");						
						while($row = mysqli_fetch_array($rights))
						{
							
								$adminRights[] = $row['Course'];
							
						}
						
						//course dropdown
						echo '<div class="col-lg-4"><form name="input" action="DashboardCourses.php?q='.$user.'" method="POST"><table width="100%"><tr><td rowspan="1"><label>Courses:</label></td><td rowspan="3"><select class="form-control" id="courseSelect" name="courseSelect" onChange="testDropdown(this.value)">';
							$rights = mysqli_query($con,"SELECT Name FROM course");						
							while($row = mysqli_fetch_array($rights))
							{   
								if($user != "ADMINS001")
								{
									foreach($adminRights as $allow)
									{
										if($allow == $row['Name'])
										{
											if($row['Name'] == $course)
											{
												echo'<option value="'.$row['Name'].'" selected="'.$row['Name'].'" >'.$row['Name'].'</option>';
											}
											else
											{
												echo'<option value="'.$row['Name'].'">'.$row['Name'].'</option>';
											}
										}
									}
								}
								else
								{
									if($row['Name'] == $course)
									{
										echo'<option value="'.$row['Name'].'" selected="'.$row['Name'].'" >'.$row['Name'].'</option>';
									}
									else
									{
										echo'<option value="'.$row['Name'].'">'.$row['Name'].'</option>';
									}
								}
							}  
						//test dropdown and checkbox
						
                        echo'</select></td></tr></table></div>';
						echo '<div class="col-lg-6"><table width="100%"><tr><td rowspan="1"><label>Test:</label></td><td rowspan="2"><select  id="testSelect" name="testSelect" class="form-control" onChange="changeDashboard(this.value)">';
							$tests = mysqli_query($con,"SELECT Name FROM test WHERE Course='CSC1010H'");						
							while($row = mysqli_fetch_array($tests))
							{
								if($row['Name'] == $test)
								{
									echo'<option value="'.$row['Name'].'" selected="'.$row['Name'].'" >'.$row['Name'].'</option>';
								}
								else
								{
									echo'<option value="'.$row['Name'].'">'.$row['Name'].'</option>';
								}
							}
						echo '</select></td><td rowspan="2">&nbsp;&nbsp;&nbsp;<input class="btn btn-default" type="submit" value="Change" name="submit" /></td></tr></table></form></div>';
						//get information about test
						$content = file_get_contents("Files/".$course."/".str_replace(" ","_",$test)."/reformattedEndMarkers.txt");
						$content = explode("<split_marker>", $content);
						$marks = explode("\n", $content[0]);
						$totalMark = trim($marks[0]);
						$questionMark = array();
						for($i = 1; $i<sizeOf($marks)-1; $i++)
						{
							$temp = explode("[",$marks[$i]);
							$questionMark[] = str_replace(" marks]", "", $temp[1]);
						}

						//get marks from student
						$getQuestionTypes = "";
						$testID = "";
						$testStuff = mysqli_query($con,"SELECT testID, TypeOfQuestions FROM test WHERE Course='".$course."' AND Name='".$test."'");						
						while($row = mysqli_fetch_array($testStuff))
						{
							$testID = $row['testID'];
							$getQuestionType = $row['TypeOfQuestions'];
							
						}
						$studentMarks = array();
						$studentQuestionMarks = array();
						$scripts = mysqli_query($con,"SELECT * FROM script WHERE Course='".$course."' AND Test=".$testID."");						
						while($row = mysqli_fetch_array($scripts))
						{
							$studentMarks[] = $row['Mark'];
							$studentQuestionMarks[] = $row['Results'];
						}
						//$numFiles = 0;
						$numFiles = -1;
						
						foreach (glob("Files/".$course."/".str_replace(" ","_",$test)."/*") as $name) 
						{
							
							$numFiles  = $numFiles +1;
						}
						$first = 0;
						$usecond = 0;
						$second = 0;
						$third = 0;
						$fail = 0;
						$absent = 0;

						foreach($studentMarks as $mark)
						{
							if(($mark/$totalMark)*100 >= 75)
							{
								$first++;
								//echo 'First: '.($mark/$totalMark)*100;
							}
							else if(($mark/$totalMark)*100 < 75 and ($mark/$totalMark)*100 >= 70)
							{
								$usecond++;
								//echo 'Second: '.($mark/$totalMark)*100;
							}
							else if(($mark/$totalMark)*100 < 70 and ($mark/$totalMark)*100 >= 60)
							{
								$second++;
								//echo 'LSecond: '.($mark/$totalMark)*100;
							}
							else if(($mark/$totalMark)*100 < 60 and ($mark/$totalMark)*100 >= 50)
							{
								$third++;
								//echo 'Third: '.($mark/$totalMark)*100;
							}
							else if(($mark/$totalMark)*100 < 50 )
							{
								$fail++;
								//echo 'Fail: '.($mark/$totalMark)*100;
							}
						}
						$count = 0;
						$getStudents = mysqli_query($con,"SELECT DISTINCT StudentNumber FROM registered_students WHERE Course='".$course."'");						
						while($row = mysqli_fetch_array($getStudents))
						{
							$count++;
						}
						$absent = $count- ($fail+$third+$second+$usecond+$first) -$numFiles;
						$unmarked = $numFiles - ($fail+$third+$second+$usecond+$first);
						if($absent < 0)
						{
							$absent =0;
						}
						$answer = $unmarked.";".$absent.";".$fail.";".$third.";".$second.";".$usecond.";".$first.'*'.$getQuestionType.'*';
						$tempMarks = array();
						$amountOfQuestions = 0;
						$amountOfStudents = sizeOf($studentMarks); 
						foreach($studentQuestionMarks as $student)
						{
							$temp = explode("+", $student);
							$amountOfQuestions = sizeOf($temp) -1;
							for($i = 1; $i <sizeOf($temp); $i++)
							{
								$tempMarks[] = $temp[$i];
								//echo $sumMarks[$i];// = $sumMarks[$i] + $temp[$i+1];
							}	
						}
						$sumQuestion = array();
						for($i = 0 ; $i <$amountOfQuestions; $i++)
						{
							$sum = 0;
							for($j = $i ; $j <sizeOf($tempMarks); $j = $j + $amountOfQuestions)
							{
								$sum = $sum +  $tempMarks[$j];
							}
							$sumQuestion[] = (($sum/$amountOfStudents)/$questionMark[$i])*100;
						}
					mysqli_close($con);	
					?>
						
					<!-- /.col-lg-12 -->
				</div>
				<div class="row">
					<div class="col-sm-6" width="100%">
					<div id="canvas-holder"  class="text-center">
					<h3>Spread of Marks</h3>
						<canvas id="chart-area" width="350" height="350"/>
					</div>	
					</div>	
					<div class="col-sm-6">
					<br><br><br><br>	
					<table class="list-group" width="80%">
					<tr><td><button class="btn btn-default btn-circle" style="background-color:#5bc0de;" disabled></button>  First </td><td>[mark >= 75%]</td></tr>
					<tr><td><button class="btn btn-default btn-circle" style="background-color:#5cb85c;" disabled></button>  Upper Second </td><td>[70% >= mark < 75%]</td></tr>
					<tr><td><button class="btn btn-default btn-circle" style="background-color:#FFDB4D;" disabled></button>  Second </td><td>[60% >= mark < 69%]</td></tr>
					<tr><td><button class="btn btn-default btn-circle" style="background-color:#FF9933;" disabled></button>  Third </td><td>[50% >= mark < 59%]</td></tr>
					<tr><td><button class="btn btn-default btn-circle" style="background-color:#d9534f;" disabled></button>  Fail </td><td>[mark < 50%]</td></tr>
					<tr><td><button class="btn btn-default btn-circle" style="background-color:#777;" disabled></button>  Absent</td><td></td></tr>
					<tr><td><button class="btn btn-default btn-circle" style="background-color:#D0D0D0;" disabled></button>  Not Marked</td><td></td></tr>
					
					</table>
					<div class="list-group">
						<?php
						/*if( $amountOfStudents !=0)
						{
							if(($fail/$amountOfStudents)*100 > 50)
							{
							echo '<a href="#" class="list-group-item">
								<i class="fa fa-warning fa-fw"></i> Majority of the class failed.
								<span class="pull-right text-muted small">
								</span>
							</a>';
							}
						}*/
						?>
					</div>
				</div>
				</div>
								<div class="row">
				<div class="col-sm-6">
					<div style="width: 100%">
					<h3 class="text-center">Average Percentage per Question</h3>
						<canvas id="BarChart" height="450" width="500"></canvas>
					</div>
				</div>
				<div class="col-sm-6">
					<br><br><br><br>	
					
					<div class="panel-group" id="accordion">
						<div>
							<div>
							<button data-toggle="collapse" data-parent="#accordion" href="#Knowlegde" type="button" class="btn btn-default" style="color:rgba(178,0,255,0.8);border-color:rgba(178,0,255,0.8)" ><span class="glyphicon glyphicon-info-sign"></span></button>  Knowledge<br>
							</div>
							<div id="Knowlegde" class="panel-collapse collapse" style="height: auto;">
								<div class="panel-body">
									Exhibit memory of learned materials by recalling facts, terms, basic concepts and answers

									<li> Knowledge of specifics - terminology, specific facts </li>
									<li>Knowledge of ways and means of dealing with specifics - conventions, trends and sequences, classifications and categories, criteria, methodology</li>
									<li>Knowledge of the universals and abstractions in a field - principles and generalizations, theories and structures</li>
									Questions like: <i>What are the health benefits of eating apples?</i>
								</div>
							</div>
						</div>
						<div>
							<div>
							<button data-toggle="collapse" data-parent="#accordion" href="#Comprehension" type="button" class="btn btn-default" style="color:rgba(107,198,225,0.8);border-color:rgba(107,198,225,0.8)" ><span class="glyphicon glyphicon-info-sign"></span></button>  Comprehension<br>
							</div>
							<div id="Comprehension" class="panel-collapse collapse" style="height: auto;">
								<div class="panel-body">
									Demonstrate understanding of facts and ideas by organizing, comparing, translating, interpreting, giving descriptions, and stating the main ideas

									<li>Translation</li>
									<li>Interpretation</li>
									<li>Extrapolation</li>
									Questions like: <i>Compare the health benefits of eating apples vs. oranges. </i>
								</div>
							</div>
						</div>
						<div>
							<div>
							<button data-toggle="collapse" data-parent="#accordion" href="#Application" type="button" class="btn btn-default" style="color:rgba(92,184,92,0.8);border-color:rgba(92,184,92,0.8)" ><span class="glyphicon glyphicon-info-sign"></span></button>  Application<br>
							</div>
							<div id="Application" class="panel-collapse collapse" style="height: auto;">
								<div class="panel-body">
									Using acquired knowledge. Solve problems in new situations by applying acquired knowledge, facts, techniques and rules in a different way

									Questions like: <i>Which kinds of apples are best for baking a pie, and why?</i>
								</div>
							</div>
						</div>
						<div>
							<div>
							<button data-toggle="collapse" data-parent="#accordion" href="#Analysis" type="button" class="btn btn-default" style="color:rgba(255,219,73,0.8);border-color:rgba(255,219,73,0.8)" ><span class="glyphicon glyphicon-info-sign"></span></button>  Anaylsis<br>
							</div>
							<div id="Analysis" class="panel-collapse collapse" style="height: auto;">
								<div class="panel-body">
									Examine and break information into parts by identifying motives or causes. Make inferences and find evidence to support generalizations

									<li>Analysis of elements</li>
									<li>Analysis of relationships</li>
									<li>Analysis of organizational principles</li>
									Questions like:<i> List four ways of serving foods made with apples and explain which ones have the highest health benefits. Provide references to support your statements.</i>
								</div>
							</div>
						</div>
						<div>
							<div>
							<button data-toggle="collapse" data-parent="#accordion" href="#Evaluation" type="button" class="btn btn-default" style="color:rgba(255,153,51,0.8);border-color:rgba(255,153,51,0.8)" ><span class="glyphicon glyphicon-info-sign"></span></button>  Evaluation<br>
							</div>
							<div id="Evaluation" class="panel-collapse collapse" style="height: auto;">
								<div class="panel-body">
								Present and defend opinions by making judgments about information, validity of ideas or quality of work based on a set of criteria

								<li>Judgments in terms of internal </li>
								<li>Judgments in terms of external criteria </li>
								Questions like: <i>Do you feel that serving apple pie for an after school snack for children is healthy?</i>
																	
								</div>
							</div>
						</div>
						<div>
							<div>
							<button data-toggle="collapse" data-parent="#accordion" href="#Synthesis" type="button" class="btn btn-default" style="color:rgba(217,83,79,0.8);border-color:rgba(217,83,79,0.8)" ><span class="glyphicon glyphicon-info-sign"></span></button>  Synthesis<br>
							</div>
							<div id="Synthesis" class="panel-collapse collapse" style="height: auto;">
								<div class="panel-body">
								Compile information together in a different way by combining elements in a new pattern or proposing alternative solutions

								<li>Production of a unique communication</li>
								<li>Production of a plan, or proposed set of operations</li>
								<li>Derivation of a set of abstract relations</li>
								Questions like: <i>Convert an "unhealthy" recipe for apple pie to a "healthy" recipe by replacing your choice of ingredients. Explain the health benefits of using the ingredients you chose vs. the original ones.	</i>
																	
								</div>
							</div>
						</div>
					</div>
					<div class="list-group">
						<?php
							for($i = 0; $i < sizeOf($sumQuestion); $i++)
							{
								if($sumQuestion[$i] < 50)
								{
								echo '<a href="#" class="list-group-item">
									<i class="fa fa-warning fa-fw"></i> Question '.($i+1).' not answered well.
									<span class="pull-right text-muted small">
									</span>
								</a>';
								}
							}
						?>
					</div>
				</div>
				</div>
				<div id="script"></div>
				<script>
					
	
					function loadGraphs()
					{
					var pieData = [
								{
									value: <?php echo $absent;?>,
									color: "rgba(64,64,64,0.6)",
									highlight: "rgba(64,64,64,0.8)",	
									label: "Absent"
								},
								{
									value: <?php echo $fail;?>,
									color:"rgba(217,83,79,0.6)" ,
									highlight: "rgba(217,83,79,0.8)",
									label: "Fail"
								},
								{
									value: <?php echo $third;?>,
									color: "rgba(255,153,51,0.6)",
									highlight: "rgba(255,153,51,0.8)",
									label: "Third"
								},
								{
									value: <?php echo $second;?>,
									color: "rgba(255,219,73,0.6)",
									highlight: "rgba(255,219,73,0.8)",
									label: "Second"
								},
								{
									value: <?php echo $usecond;?>,
									color: "rgba(92,184,92,0.6)",
									highlight: "rgba(92,184,92,0.8)",
									label: "Upper Second"
								},
								{
									value: <?php echo $first;?>,
									color: "rgba(107,198,225,0.6)",
									highlight: "rgba(107,198,225,0.8)",
									label: "First"
								}
								,
								{
									value: <?php echo $unmarked?>,
									color: "rgba(208,208,208,0.6)",
									highlight: "rgba(208,208,208,0.8)",
									label: "Not Marked"
								}

							];
							
							var ctx = document.getElementById("chart-area").getContext("2d");
							window.myPie = new Chart(ctx).Pie(pieData);
							
							var randomScalingFactor = function(){ return Math.round(Math.random()*100)};

							
						Chart.types.Bar.extend({
		
						name: "BarOneTip",
						initialize: function(data){
							Chart.types.Bar.prototype.initialize.apply(this, arguments);
						},
						getBarsAtEvent : function(e){
								var barsArray = [],
									eventPosition = Chart.helpers.getRelativePosition(e),
									datasetIterator = function(dataset){
										barsArray.push(dataset.bars[barIndex]);
									},
									barIndex;

								for (var datasetIndex = 0; datasetIndex < this.datasets.length; datasetIndex++) {
									for (barIndex = 0; barIndex < this.datasets[datasetIndex].bars.length; barIndex++) {
										if (this.datasets[datasetIndex].bars[barIndex].inRange(eventPosition.x,eventPosition.y)){
											
											//change here to only return the intrested bar not the group
											barsArray.push(this.datasets[datasetIndex].bars[barIndex]);
											return barsArray;
										}
									}
								}

								return barsArray;
							},
						showTooltip : function(ChartElements, forceRedraw){
							console.log(ChartElements);
								// Only redraw the chart if we've actually changed what we're hovering on.
								if (typeof this.activeElements === 'undefined') this.activeElements = [];

								var isChanged = (function(Elements){
									var changed = false;

									if (Elements.length !== this.activeElements.length){
										changed = true;
										return changed;
									}

									Chart.helpers.each(Elements, function(element, index){
										if (element !== this.activeElements[index]){
											changed = true;
										}
									}, this);
									return changed;
								}).call(this, ChartElements);

								if (!isChanged && !forceRedraw){
									return;
								}
								else{
									this.activeElements = ChartElements;
								}
								this.draw();
								console.log(this)
								if (ChartElements.length > 0){
									
									//removed the check for multiple bars at the index now just want one
										Chart.helpers.each(ChartElements, function(Element) {
											var tooltipPosition = Element.tooltipPosition();
											new Chart.Tooltip({
												x: Math.round(tooltipPosition.x),
												y: Math.round(tooltipPosition.y),
												xPadding: this.options.tooltipXPadding,
												yPadding: this.options.tooltipYPadding,
												fillColor: this.options.tooltipFillColor,
												textColor: this.options.tooltipFontColor,
												fontFamily: this.options.tooltipFontFamily,
												fontStyle: this.options.tooltipFontStyle,
												fontSize: this.options.tooltipFontSize,
												caretHeight: this.options.tooltipCaretSize,
												cornerRadius: this.options.tooltipCornerRadius,
												text: Chart.helpers.template(this.options.multiTooltipTemplate, Element),
												chart: this.chart
											}).draw();
										}, this);
									
								}
								return this;
							}
						
					});
						
											  


					var ctx = document.getElementById("BarChart").getContext("2d");
					var data = {
						labels: ["Question"],
						datasets: [
						<?php 
							$getQuestionType =explode("+", $getQuestionType);
					
							for($i = 0; $i < sizeOf($sumQuestion); $i++)
							{
								$color = "";
								if(trim($getQuestionType[$i+1]) == "knowledge")
								{
									$color ="rgba(178,0,255,0.8)";
								}
								else if(trim($getQuestionType[$i+1]) == "comprehension")
								{
									$color ="rgba(107,198,225,0.8)";
								}
								else if(trim($getQuestionType[$i+1]) == "application")
								{
									$color ="rgba(92,184,92,0.8)";
								}
								else if(trim($getQuestionType[$i+1]) == "analysis")
								{
									$color ="rgba(255,219,73,0.8)";
								}
								else if(trim($getQuestionType[$i+1]) == "evaluation")
								{
									$color ="rgba(255,153,51,0.8)";
								}
								else if(trim($getQuestionType[$i+1]) == "synthesis")
								{
									$color ="rgba(217,83,79,0.8)";
								}
								if($i < sizeOf($sumQuestion)-1)
								{
									echo'{label: "Question '.($i+1).'",
									fillColor: "rgba(225,225,225,0)",
									strokeColor: "'.$color.'",
									highlightFill: "rgba(225,225,225,0)",
									highlightStroke: "'.$color.'",
									data: ['.number_format($sumQuestion[$i],0).']},';
								}
								else
								{
									echo'{label: "Question '.($i+1).'",
									fillColor: "rgba(225,225,225,0)",
									strokeColor: "'.$color.'",
									highlightFill: "rgba(225,225,225,0)",
									highlightStroke: "'.$color.'",
									data: ['.number_format($sumQuestion[$i],0)	.']}';
								}
							}
						?>
							
						]
					};


					var myBarChart = new Chart(ctx).BarOneTip(data, {
							//responsive : true,
							multiTooltipTemplate: "<%= datasetLabel %> - <%= value %>"
						});
					//alert(str);
					/*info = str.split("*");
					data = info[0].split(";");
					
						var pieData = [
								{
									value: parseFloat(data[1]),
									color: "rgba(64,64,64,0.6)",
									highlight: "rgba(64,64,64,0.8)",	
									label: "Absent"
								},
								{
									value: parseFloat(data[2]),
									color:"rgba(217,83,79,0.6)" ,
									highlight: "rgba(217,83,79,0.8)",
									label: "Fail"
								},
								{
									value: parseFloat(data[3]),
									color: "rgba(255,153,51,0.6)",
									highlight: "rgba(255,153,51,0.8)",
									label: "Third"
								},
								{
									value: parseFloat(data[4]),
									color: "rgba(255,219,73,0.6)",
									highlight: "rgba(255,219,73,0.8)",
									label: "Second"
								},
								{
									value: parseFloat(data[5]),
									color: "rgba(92,184,92,0.6)",
									highlight: "rgba(92,184,92,0.8)",
									label: "Upper Second"
								},
								{
									value: parseFloat(data[6]),
									color: "rgba(107,198,225,0.6)",
									highlight: "rgba(107,198,225,0.8)",
									label: "First"
								},
								{
									value: parseFloat(data[0]),
									color: "rgba(208,208,208,0.6)",
									highlight: "rgba(208,208,208,0.8)",
									label: "Not Marked"
								}

							];
							
							var ctx = document.getElementById("chart-area").getContext("2d");
							window.myPie = new Chart(ctx).Pie(pieData);
					QuestionType = info[1].split("+");
					SumQuestion = info[2].split("+");
					alert(QuestionType[1]);
					Chart.types.Bar.extend({
		
						name: "BarOneTip",
						initialize: function(data){
							Chart.types.Bar.prototype.initialize.apply(this, arguments);
						},
						getBarsAtEvent : function(e){
								var barsArray = [],
									eventPosition = Chart.helpers.getRelativePosition(e),
									datasetIterator = function(dataset){
										barsArray.push(dataset.bars[barIndex]);
									},
									barIndex;

								for (var datasetIndex = 0; datasetIndex < this.datasets.length; datasetIndex++) {
									for (barIndex = 0; barIndex < this.datasets[datasetIndex].bars.length; barIndex++) {
										if (this.datasets[datasetIndex].bars[barIndex].inRange(eventPosition.x,eventPosition.y)){
											
											//change here to only return the intrested bar not the group
											barsArray.push(this.datasets[datasetIndex].bars[barIndex]);
											return barsArray;
										}
									}
								}

								return barsArray;
							},
						showTooltip : function(ChartElements, forceRedraw){
							console.log(ChartElements);
								// Only redraw the chart if we've actually changed what we're hovering on.
								if (typeof this.activeElements === 'undefined') this.activeElements = [];

								var isChanged = (function(Elements){
									var changed = false;

									if (Elements.length !== this.activeElements.length){
										changed = true;
										return changed;
									}

									Chart.helpers.each(Elements, function(element, index){
										if (element !== this.activeElements[index]){
											changed = true;
										}
									}, this);
									return changed;
								}).call(this, ChartElements);

								if (!isChanged && !forceRedraw){
									return;
								}
								else{
									this.activeElements = ChartElements;
								}
								this.draw();
								console.log(this)
								if (ChartElements.length > 0){
									
									//removed the check for multiple bars at the index now just want one
										Chart.helpers.each(ChartElements, function(Element) {
											var tooltipPosition = Element.tooltipPosition();
											new Chart.Tooltip({
												x: Math.round(tooltipPosition.x),
												y: Math.round(tooltipPosition.y),
												xPadding: this.options.tooltipXPadding,
												yPadding: this.options.tooltipYPadding,
												fillColor: this.options.tooltipFillColor,
												textColor: this.options.tooltipFontColor,
												fontFamily: this.options.tooltipFontFamily,
												fontStyle: this.options.tooltipFontStyle,
												fontSize: this.options.tooltipFontSize,
												caretHeight: this.options.tooltipCaretSize,
												cornerRadius: this.options.tooltipCornerRadius,
												text: Chart.helpers.template(this.options.multiTooltipTemplate, Element),
												chart: this.chart
											}).draw();
										}, this);
									
								}
								return this;
							}
						
					});
				
					/*var ctx = document.getElementById("BarChart").getContext("2d");
					var data = {
						labels: ["Question"],
						datasets: [
											
							for (var i = 0; i < 5; i++)
							{
								color = "rgba(217,83,79,0.8)";
								/*if(trim(QuestionType[i+1]) == "knowledge")
								{
									color ="rgba(178,0,255,0.8)";
								}
								else if(trim(QuestionType[i+1]) == "comprehension")
								{
									color ="rgba(107,198,225,0.8)";
								}
								else if(trim(QuestionType[i+1]) == "application")
								{
									color ="rgba(92,184,92,0.8)";
								}
								else if(trim(QuestionType[i+1]) == "analysis")
								{
									color ="rgba(255,219,73,0.8)";
								}
								else if(trim(QuestionType[i+1]) == "evaluation")
								{
									color ="rgba(255,153,51,0.8)";
								}
								else if(trim(QuestionType[i+1]) == "synthesis")
								{
									color ="rgba(217,83,79,0.8)";
								}*/
								/*if(i < (SumQuestion.length)
								{
									{label: "Question",
									fillColor: "rgba(225,225,225,0)",
									strokeColor: color,
									highlightFill: "rgba(225,225,225,0)",
									highlightStroke: color,
									data: [SumQuestion[i]]},
								}
								else
								{
									{label: "Question ",
									fillColor: "rgba(225,225,225,0)",
									strokeColor: color,
									highlightFill: "rgba(225,225,225,0)",
									highlightStroke: color,
									data: [SumQuestion[i]]}
								}
							}
							
						]
					};


					var myBarChart = new Chart(ctx).BarOneTip(data, {
							//responsive : true,
							multiTooltipTemplate: "<%= datasetLabel %> - <%= value %>"
						});*/
						
						
				
				
						}

					</script>
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
	<script src="js/Chart.js"></script>

    <!-- Page-Level Plugin Scripts - Panels and Wells -->

    <!-- SB Admin Scripts - Include with every page -->
    <script src="js/sb-admin.js"></script>
	<script>
	function testDropdown(value)
	{
		var xmlhttp=new XMLHttpRequest();
		  xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			  document.getElementById("testSelect").innerHTML=xmlhttp.responseText;
			  //alert(xmlhttp.responseText);
			}
		  }
		  xmlhttp.open("GET","TestDropdown.php?q="+value,true);
		  xmlhttp.send();
		  changeDashboard(document.getElementById("testSelect").value)
	}
	function changeDashboard()
	{
		/*info = document.getElementById("courseSelect").value+" , "+document.getElementById("testSelect").value;
		var xmlhttp=new XMLHttpRequest();
		  xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			  //document.getElementById("script").innerHTML=xmlhttp.responseText;
				info = xmlhttp.responseText;
				//alert(data[0]);
				
				loadGraphs(info);
			}
		  }
		  xmlhttp.open("GET","DashboardGraphs.php?q="+info,true);
		  xmlhttp.send();*/
	}
	function Logout() {
		
		var info = document.getElementById("user").value;
		//alert(info);
		var xmlhttp=new XMLHttpRequest();
		  xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			  //document.getElementById("notificationPanel").innerHTML=xmlhttp.responseText;
			  //alert(xmlhttp.responseText);
			}
		  }
		  xmlhttp.open("GET","Logout.php?q="+info,true);
		  xmlhttp.send();
	}
	</script>

    <!-- Page-Level Demo Scripts - Panels and Wells - Use for reference -->

</body>

</html>
