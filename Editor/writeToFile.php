<?php
//get position
$info = $_REQUEST["q"];
$info = explode("/",$info);
$test = str_replace(" ", "+",$info[0]);
$position= $info[1];
//echo "this is from a php file~: ".$position;
$file = "uploads/".$test."/tickCoordinates.txt";
$content = file_get_contents($file);
if(strpos($content,$position) === false)
{
file_put_contents($file, $content.$position);
}

?>
