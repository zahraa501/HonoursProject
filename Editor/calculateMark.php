<?php
$contentTick = file_get_contents("uploads/1-Class_Test_2-20140904_1244+/tickType.txt");
$contentType = explode("*",str_replace("uploads/This is the tick type and page for: 1-Class_Test_2-20140904_1244+","",$contentTick));

$mark = 0;
foreach($contentType as $type)
{
	$type = explode(" ",$type);
	if(strpos($type[0],"tick")|| $type[0] == "tick" )
	{
		$mark = $mark + 1;
	}
	else if(strpos($type[0],"half") || $type[0] == "half")
	{
		$mark = $mark + 0.5;
	}
}
//echo "The final mark is: ".$mark;
$file = "1-Class_Test_2-20140904_1244/marks.txt";

file_put_contents($file, "This is the marks for: 1-Class_Test_2-20140904_1244+\n".$mark);
echo '<button type="button" class="btn btn-success disabled">';
echo "Mark: ".$mark;
echo '</button>';
?>