<?php
//get username
$user = $_REQUEST["q"];
//connect to db
$con=mysqli_connect("localhost:3306","root","Changmin88","honours_project");
//set timezone
date_default_timezone_set('Africa/Johannesburg');
$date = date("Y-m-d h:i:sa");
//update logout 
$UpdateQuery = "UPDATE staff SET LastLogout ='".$date."' WHERE StaffID='".strtoupper($user)."'";               
mysqli_query($con, $UpdateQuery);
mysqli_close($con);
?>