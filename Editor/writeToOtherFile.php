<?php
//get position "1-Class_Test_2-20140904_1244 /".
$info = $_REQUEST["q"]."*";

$info = explode("/",$info);
$test = str_replace(" ", "+",$info[0]);
$position= $info[1];
$contentTick = file_get_contents("uploads/".$test."/tickType.txt");
//echo $contentTick;

file_put_contents("uploads/".$test."/tickType.txt", $contentTick.$position);

?>
