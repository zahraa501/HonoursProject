<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
/*$local = '/home/system/www/public_html/mthzah002/System/uploads/0-Class_Test_2-20140904_1240+/';
$server = '/home/zmathews/Honours_Project/CSC1010H/Class_Test_2/0-Class_Test_2-20140904_1240+/';

// login with username and password
$connection = ssh2_connect('nightmare.cs.uct.ac.za', 22);
ssh2_auth_password($connection, 'zmathews', '800hazhtM');
$sftp = ssh2_sftp($connection);

//moving file
ssh2_sftp_rename($sftp, $local, $server);

echo "Success~";*/
	//create file that stores coordinates
	$myfile = fopen("/home/system/www/public_html/mthzah002/System/tickCoordinates.txt", "w");
	file_put_contents("/home/system/www/public_html/mthzah002/System/tickCoordinates.txt", 'This is the tick co-ordinates for:\n');
	fclose($myfile); 
?>