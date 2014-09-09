<?php
$ftp_server = "127.0.0.1";
$ftp_user_name = "zahraa";
$ftp_user_pass = "";

	// set up basic connection
	$conn_id = ftp_connect($ftp_server);

	// login with username and password
	$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
	
	//file that needs to move from file server to server
	$fileExtention = $_REQUEST["q"];
	$fileSplit = explode("/", $fileExtention);
	
	//File name for comparision
	$fileName = $fileSplit[2];
	
	//1) check if file is already available on server
	$Exist =  file_exists($fileName); 

	//2) if not available then download
	if($Exist !== 1)
	{
		$local_file = 'uploads/'.$fileName;
		//echo $_REQUEST["q"].'<br>';
		//echo $local_file;

		// initiate download

		$d = ftp_nb_get($conn_id, $local_file, $_REQUEST["q"], FTP_ASCII);
		while ($d == FTP_MOREDATA)
		  {
		  // do whatever you want
		  // continue downloading
		  $d = ftp_nb_continue($conn_id);
		  }

		if ($d != FTP_FINISHED)
		  {
		  echo "Error downloading $server_file";
		  exit(1);
		  }
			$greenAlert = '"alert alert-success"';
			echo "<div class=".$greenAlert.">";
			echo 'Filezilla Server directory extention: '.$_REQUEST["q"].'<br>';
			echo 'Server directory extention: '.$local_file.'<br>';
			echo "success!!!</div>";
	}
	//3) if available open the editor or lock the test
	ftp_close($conn_id);

?>