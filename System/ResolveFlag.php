<?php
$con=mysqli_connect("localhost:3306","root","Changmin88","honours_project");
//change status
$UpdateQuery = "UPDATE flag SET Status='Resolve' WHERE flagID='".$_REQUEST["q"]."'";	
mysqli_query($con, $UpdateQuery);	
//refresh view
$result = mysqli_query($con,"SELECT * FROM flag WHERE Status='Alert'");					
while($rs = mysqli_fetch_array($result)) 
{
	echo '<a href="#" id="notification" name="'.$rs['flagID'].'*'.$rs['Course'].' Script Flagged" class="list-group-item" data-toggle="modal" data-target="#myModal" onclick="setModal(\''.$rs['Comment'].'\')">
		 <i class="glyphicon glyphicon-flag"></i>  '.$rs['Course'].' Script Flagged</a>';
}			
mysqli_close($con);
?>