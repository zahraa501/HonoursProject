<?php
$info = explode(" ", $_REQUEST["q"]);
$ID = $info[0];
$pass = $info[1];
$con=mysqli_connect("localhost:3306","root","Changmin88","honours_project");
$UpdateQuery ="Update staff SET Password='".crypt($pass, 'PASSWORD_DEFAULT')."' WHERE StaffID='".$ID."'";
mysqli_query($con, $UpdateQuery);
mysqli_close($con);
echo '<div class="alert alert-success alert-dismissable">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true" >×</button>
Password has been updated.
</div>';
?>