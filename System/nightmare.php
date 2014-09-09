<?php
if (!function_exists("ssh2_connect")) die("function ssh2_connect doesn't exist");
$connection = ftp_connect('nightmare.cs.uct.ac.za', 22);
$login_result = ftp_login($conn_id, 'zmathews', '800hazhtM');
if (login_result) {
  echo "Authentication Successful!\n";
} else {
  die('Authentication Failed...');
}
//$sftp = ssh2_sftp($connection);
?>