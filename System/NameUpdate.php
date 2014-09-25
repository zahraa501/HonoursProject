<?php
$info = explode("-", $_REQUEST["q"]);
$ID = $info[0];
$name = $info[1];
$con=mysqli_connect("localhost:3306","root","Changmin88","honours_project");
$UpdateQuery ="Update staff SET name='".$name."' WHERE StaffID='".$ID."'";
mysqli_query($con, $UpdateQuery);
mysqli_close($con);
echo '<div class="alert alert-success alert-dismissable">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true" >×</button>
Name has been updated.
</div>';
?>