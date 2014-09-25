<?php
$sent = explode("/", $_REQUEST["q"]);
$course = $sent[0];
$test = $sent[1];
$ID = "";
$script = str_replace(" ", "+", $sent[2]);
$tutor  = $sent[4];
$comment = $sent[5];
$con=mysqli_connect("localhost:3306","root","Changmin88","honours_project");
			
$testID = mysqli_query($con,"SELECT testID FROM test WHERE Course='".$course."' And Name='".str_replace("_"," ",$test)."'");	
while($row = mysqli_fetch_array($testID))
{	
	$ID = $row['testID'];
}	
$AddQuery ="INSERT INTO flag(Course, Test, Tutor,Script,Comment,Status)
VALUES
('".$course."','".$ID."','".$tutor."','".$script."','".$comment."','Alert')";
mysqli_query($con, $AddQuery);
mysqli_close($con);

?>