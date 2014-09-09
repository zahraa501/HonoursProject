<?php
		$connection = ssh2_connect('nightmare.cs.uct.ac.za', 22);
		$sftp = ssh2_sftp($connection);

		if (ssh2_auth_password($connection, 'zmathews', '800hazhtM')) {
		//echo "Authentication Successful!\n";
		} else {
  		die('Authentication Failed...');
		}
								
error_reporting(E_ALL);
ini_set('display_errors', 1);
$pdf = '/home/system/www/public_html/mthzah002/System/uploads/temp.pdf[2]';
$image = new Imagick($pdf);

$image->setImageFormat( "png" );
//echo ssh2_scp_send($connection,$image,"/home/zmathews/Honours_Project/temp.png",0644));
header("Content-type: image/png"); 
echo $image;  
//echo "test";
//$image->writeImage ("/home/system/www/public_html/mthzah002/System/uploads/temp.png");
//file_put_contents("/home/system/www/public_html/mthzah002/System/uploads/temp.png", $image);

?>