<?php
$name = "uploads/".$_REQUEST["q"];
$dir = new DirectoryIterator($name.'/');
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

if($files == 0)
{
	//create file that stores coordinates
	$myfile = fopen($name."/tickCoordinates.txt", "w");
	file_put_contents($name."/tickCoordinates.txt", 'This is the tick co-ordinates for: '.$name.'\n');
	fclose($myfile); 
	
	//create file that stores tick types
	$myOtherfile = fopen($name."tickType.txt", "w");
	file_put_contents($name."/tickType.txt", 'This is the tick type and page for: '.$name.'\n');
	fclose($myOtherfile); 
	
	//create file that stores marks
	$marks = fopen($name."/marks.txt", "w");
	file_put_contents($name."/marks.txt", 'This is the marks for: '.$name.'\n0');
	fclose($marks);
}
?>