<?php
$info = explode("*",$_REQUEST["q"]);
$staff = $info[0];
$course = $info[1];
$role = $info[2];

$con=mysqli_connect("localhost:3306","root","Changmin88","honours_project");
//delete selected role
$DeleteRole ="DELETE FROM jobs WHERE Course='".$course."' AND StaffID='".$staff."' AND Role='".$role."'";
mysqli_query($con, $DeleteRole);
//update staff members Type 
$role = array();
$checkRoles = mysqli_query($con,"SELECT Role FROM jobs WHERE StaffID='".$staff."'");						
while($row = mysqli_fetch_array($checkRoles))
{
	$role = $row['Role'];
}
$newRole = "";
if(sizeOf($role)==0)
{
	$newRole = "Nothing";
}
else if(sizeOf($role)==1)
{
	$newRole = $role[0];
}
else
{
	$newRole = $role[0];
	if($newRole != "Course Convener")
	{
		for($i = 1; $i < sizeOf($role); $i++)
		{
			if($role[$i] == "Course Convener" and  $newRole == "Teaching Assistant")
			{
				$newRole = "Course Convener";
			}
			else if($role[$i] == "Teaching Assistant" and  $newRole == "Lecturer")
			{
				$newRole = "Teaching Assistant";
			}
			else if($role[$i] == "Course Convener" and  $newRole == "Lecturer")
			{
				$newRole = "Course Convener";
			}
			else if($role[$i] == "Course Convener" and  $newRole == "Tutor")
			{
				$newRole = "Course Convener";
			}
			else if($role[$i] == "Teaching Assistant" and  $newRole == "Tutor")
			{
				$newRole = "Teaching Assistant";
			}
			else if($role[$i] == "Lecturer" and  $newRole == "Tutor")
			{
				$newRole = "Lecturer";
			}
		}
	}
}
//delete selected role
$UpdateRole ="UPDATE staff SET Type='".$newRole."' WHERE StaffID='".$staff."'";
mysqli_query($con, $UpdateRole);
mysqli_close($con);

?>