<?php
// get the q parameter from URL
$course=$_REQUEST["q"]; $answer="";

$url = "nightmare.cs.uct.ac.za:3306";
										// login with username and password

//$connection = ssh2_connect('nightmare.cs.uct.ac.za', 22);
//$sftp = ssh2_sftp($connection);

/*if (ssh2_auth_password($connection, 'zmathews', '800hazhtM')) {
//echo "Authentication Successful!\n";


} else {
  die('Authentication Failed...');
}*/

// Connect to DB
	//$con = mysql_connect($url,"zmathews","quohfeex","zmathews");
	$con=mysqli_connect("localhost:3306","root","Changmin88","honours_project");

// Check connection
if (!$con) 
{
	echo "<div class=".$redAlert.">";
	echo "Failed to connect to MySQL (".$url."): " . mysql_error();
	echo "</div>";

}
//specify table
//mysql_select_db('zmathews');

	echo '<select name=Test class=form-control>';
	//query for test names
	/*$selectQueryTest = "SELECT Name FROM test WHERE Course='".$course."'";
	$resultTest = mysql_query($selectQueryTest)or die(mysql_error());
	
	//populate dropdown options
	while($test = mysql_fetch_array($resultTest, MYSQL_ASSOC))
{
	$TestName = $test['Name'];
	echo '<option value="'.$TestName.'">'.$TestName.'</option>';
}	echo '</select>';*/
$selectQueryTest = mysqli_query($con,"SELECT Name FROM test WHERE Course='".$course."'");						
while($test= mysqli_fetch_array($selectQueryTest))
{
	$TestName = $test['Name'];
	echo '<option value="'.$TestName.'">'.$TestName.'</option>';
}

echo '</select></div></th></tr>';
?>