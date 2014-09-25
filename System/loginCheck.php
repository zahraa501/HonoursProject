<?php
$info = $_REQUEST["q"];
$info = explode(" ", $info);

$con=mysqli_connect("localhost:3306","root","Changmin88","honours_project");
$response = "Please fill in all the fields above";
$pass = "";
if(sizeOf($info)==2)
{
$pass = $info[1];
}
$checkName = mysqli_query($con,"SELECT name, Password FROM staff WHERE StaffID='".strtoupper($info[0])."'");
$success = false;						
while($row = mysqli_fetch_array($checkName))
{
	$user_input = crypt($pass);
	if($row['Password']==$pass)
	{
		$success = true;
	}
	else if (crypt($user_input, $row['Password'])) 
	{
		$success = true;
	}
}

if($success == false )
{
	$response = "Incorrect information given.";
	echo $response;
}
else
{
	date_default_timezone_set('Africa/Johannesburg');
	//$d = mktime(11, 14, 54, 8, 12, 2014);
	$date = date("Y-m-d h:i:sa");
	$UpdateQuery = "UPDATE staff SET LastLogin ='".$date."' WHERE StaffID='".strtoupper($info[0])."'";               
	mysqli_query($con, $UpdateQuery);
	echo $success;
}
mysqli_close($con);
?>