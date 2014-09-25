<?php
$sent = explode("*", $_REQUEST["q"]);
$info = $sent[1];
$info = str_replace(" ","+",$info);
$split = explode("/", $info);
echo 'Files'.str_replace("page2.png","",$info);
$dir = new DirectoryIterator('Files'.str_replace("page2.png","",$info));


$tickCoordinates = "false";
$tickType = "false";
$files = 0;
$fileCount = 0;
$test = str_replace(" ","+",$split[2]);
foreach($dir as $file )
{
	if(strpos($file, ".txt")>0)
	{
		$files = $files + 1;
	}
	//checks is the file is an image	
	if(strpos($file, ".png")>0)
	{
		$fileCount = $fileCount +1;
	}	
}
$content = "";
//create template for files
for($num =1; $num<=$fileCount; $num++)
{
	$content = $content."Page_".$num."\n";
}
if($files == 0)
{
	//create file that stores coordinates
	$myfile = fopen('Files'.str_replace("page2.png","",$info).'/tickCoordinates.txt', "w");
	//file_put_contents('Files'.str_replace("page2.png","",$info).'/tickCoordinates.txt', "This is the tick co-ordinates for: ".$test."\n");
	fclose($myfile); 
	
	//create file that stores tick types
	$myOtherfile = fopen('Files'.str_replace("page2.png","",$info).'/tickType.txt', "w");
	//file_put_contents('Files'.str_replace("page2.png","",$info).'/tickType.txt', "This is the tick type and page for: ".$test."\n");
	fclose($myOtherfile); 
	
	//create file that stores marks
	$marks = fopen('Files'.str_replace("page2.png","",$info).'/marks.txt', "w");
	file_put_contents('Files'.str_replace("page2.png","",$info).'/marks.txt', "This is the marks for: ".$test."\n0");
	fclose($marks);
}
?>