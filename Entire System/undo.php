<?php
//directory and page number
$info = $_REQUEST["q"];
//split information 
$info = explode("/", $info);
$test = str_replace(" ", "+",$info[2]);

//filename
$file = "Files/".$info[0].'/'.$info[1].'/'.$test."/tickCoordinates.txt";
$fileType = "Files/".$info[0].'/'.$info[1].'/'.$test."/tickType.txt";
$fileMark = "Files/".$info[0].'/'.$info[1].'/'.$test."/marks.txt";

//retrieve content of files
$content = file_get_contents($file);
$contentType = file_get_contents($fileType);
$mark = file_get_contents($fileMark);

//split tick type information
$content = explode("*",str_replace("This is the tick co-ordinates for: ".$test."","",$content));
$contentType = explode("*",str_replace("This is the tick type and page for: ".$test."","",$contentType));
$mark = str_replace("This is the marks for: ".$test."","",$mark);
//page number
$page = str_replace("page", "",str_replace(".png", "", $info[3]));


//line that needs to be deleted
$line = 0;
for($num = 0; $num<sizeOf($contentType)-1; $num++)
{
	$information = explode(" ",$contentType[$num]);
	
	if($information[1] == $page)
	{
		//how to determine value has changed
		$line = $num;
		
	}
}
$type = explode(" ",$contentType[$line]);

//delete line that isn't wanted
$newContent = "This is the tick co-ordinates for: ".$test."\n";
$newContentType = "This is the tick type and page for: ".$test."\n";


for($num = 0; $num<sizeOf($contentType)-1; $num++)
{
	$information = explode(" ",$contentType[$num]);
	if($num !== $line)
	{
		//append to new content
		$newContent = $newContent.$content[$num]."*";
		$newContentType = $newContentType.$contentType[$num]."*"; 

	}
	
}

$tick = explode(" ",$contentType[$line]);
//sends the tick type and coordinate
echo $content[$line]." ".$tick[0];
//deletes the old coordinate
file_put_contents($file, $newContent);
file_put_contents($fileType, $newContentType);

?>