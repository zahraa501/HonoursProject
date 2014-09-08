<?php
//directory and page number
$info = $_REQUEST["q"];
//split information 
$info = explode("/", $info);
$test = str_replace(" ", "+",$info[0]);

//filename
$file = "uploads/".$test."/tickCoordinates.txt";
$fileType = "uploads/".$test."/tickType.txt";
$fileMark = "uploads/".$test."/marks.txt";

//retrieve content of files
$content = file_get_contents($file);
$contentType = file_get_contents($fileType);
$mark = file_get_contents($fileMark);

//split tick type information
$content = explode("*",str_replace("This is the tick co-ordinates for: ".$test."","",$content));
$contentType = explode("*",str_replace("This is the tick type and page for: ".$test."","",$contentType));
$mark = str_replace("This is the marks for: ".$test."","",$mark);
//page number
$page = str_replace("page", "",str_replace(".png", "", $info[1]));


//line that needs to be deleted
$line = 0;
for($num = 0; $num<sizeOf($contentType)-1; $num++)
{
	
	$information = explode(" ",$contentType[$num]);
	//echo $information[1].' : '.$page.'<br>';
	if($information[1] == $page)
	{
		//how to determine value has changed
		$line = $num;
		
	}
}
$type = explode(" ",$contentType[$line]);
//echo $type[0];
//echo $line;
//delete line that isn't wanted
$newContent = "This is the tick co-ordinates for: 1-Class_Test_2-20140904_1244+\n";
$newContentType = "This is the tick type and page for: 1-Class_Test_2-20140904_1244+\n";


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

//echo $newContent."<br>";
//echo $newContentType."<br>";
$tick = explode(" ",$contentType[$line]);

/*if(strpos($tick[0],"tick")|| $tick[0] === "tick")
{ 
	$mark = $mark-1;
}
else if(strpos($tick[0],"half")|| $tick[0] === "half")
{
	$mark = $mark -0.5;
}*/
//echo $tick[0];
echo $content[$line]." ".$tick[0];
//file_put_contents($file, $newContent);
//file_put_contents($fileType, $newContentType);
//file_put_contents($fileMark, "This is the marks for: 1-Class_Test_2-20140904_1244\n".$mark);

?>