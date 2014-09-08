<?php
$info = $_REQUEST["q"];
$info = explode("/", $info);
$test = str_replace(" ","+",$info[2]);
$dir = new DirectoryIterator('uploads/'.$test.'/');
$tickCoordinates = "false";
$tickType = "false";
$files = 0;
$fileCount = 0;
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
	$myfile = fopen('uploads/'.$test.'/tickCoordinates.txt', "w");
	file_put_contents('uploads/'.$test.'/tickCoordinates.txt', "This is the tick co-ordinates for: ".$test."\n");
	fclose($myfile); 
	
	//create file that stores tick types
	$myOtherfile = fopen('uploads/'.$test.'/tickType.txt', "w");
	file_put_contents('uploads/'.$test.'/tickType.txt', "This is the tick type and page for: ".$test."\n");
	fclose($myOtherfile); 
	
	//create file that stores marks
	$marks = fopen('uploads/'.$test.'/marks.txt', "w");
	file_put_contents('uploads/'.$test.'/marks.txt', "This is the marks for: ".$test."\n0");
	fclose($marks);
}
?>