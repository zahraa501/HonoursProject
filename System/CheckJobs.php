<?php
$staffID = $_REQUEST["q"];
// Connect to DB
//$con = mysql_connect($url,"zmathews","quohfeex","zmathews");
$con=mysqli_connect("localhost:3306","root","Changmin88","honours_project");

//the jobs the staff member is already assigned to 
$staffCourses = array();
$result = mysqli_query($con,"SELECT Course FROM jobs WHERE StaffID='".$staffID."'");						
while($row = mysqli_fetch_array($result))
{
	$staffCourses[] = $row['Course'];
}
//the courses available
$Courses = array();
$result = mysqli_query($con,"SELECT Name FROM course");						
while($c = mysqli_fetch_array($result))
{
	$Courses[] = $c['Name'];

}
mysqli_close($con);
//create dropdown for courses
echo '<select name=Course class=form-control>';
for($x =0; $x < sizeOf($Courses); $x++)
{	
	$show = 0;
	
	for($y =0; $y < sizeOf($staffCourses); $y++)
	{
		if($staffCourses[$y] == $Courses[$x])
		{
			$show = 1;
		}
	}
	if($show == 0)
	{
		echo '<option value='.$Courses[$x].'>'.$Courses[$x].'</option>';
	}
}
echo '</select>';

?>