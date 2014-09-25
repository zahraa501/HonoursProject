<?php
//get position
$info = $_REQUEST["q"];
$info = explode("/",$info);
$test = str_replace(" ", "+",$info[2]);
$position= $info[3];
//echo "this is from a php file~: ".$position;
$file = "Files/".$info[0].'/'.$info[1].'/'.$test."/tickCoordinates.txt";
$content = file_get_contents($file);
if(strpos($content,$position) === false)
{
file_put_contents($file, $content.$position);
}

?>
