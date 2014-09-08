<?php
//get position
$info = $_REQUEST["q"];
echo $info;
$info = explode(" /",$info);

$mark = $info[1];

$test = $info[0]."+";
//echo "this is from a php file~: ".$position;
$file = "uploads/".$test."/marks.txt";

file_put_contents($file, 'This is the marks for: '.$test.' '.$mark);


?>