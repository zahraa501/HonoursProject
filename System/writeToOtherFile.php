<?php
//get position "1-Class_Test_2-20140904_1244 /".
$info = $_REQUEST["q"]."*";
$info = explode("/",$info);
$test = str_replace(" ", "+",$info[2]);
$position= $info[3];
$contentTick = file_get_contents("Files/".$info[0].'/'.$info[1].'/'.$test."/tickType.txt");
//echo $contentTick;

file_put_contents("Files/".$info[0].'/'.$info[1].'/'.$test."/tickType.txt", $contentTick.$position);

?>
