<?php
//get position
$info = $_REQUEST["q"];

$splitInfo= explode("/",$info);
$mark = $splitInfo[3];
$test = str_replace(" ","",$splitInfo[2]);
$full = $splitInfo[0].'/'.$splitInfo[1].'/'.$test."+";

$file = "Files/".$full."/marks.txt";

file_put_contents($file, 'This is the marks for: '.$test.' '.$mark);


?>