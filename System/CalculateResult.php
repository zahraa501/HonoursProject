<?php
//get tick information for each question
$contentTicks = file_get_contents("Files/CSC4000W/Test_1/MPTSIN003+/tickType.txt");
$contentTicks = explode("*", $contentTicks);
//get information of test
$content = file_get_contents("Files/CSC4000W/Test_1/reformattedEndMarkers.txt");
$content = explode("<split_marker>", $content);
$marks = explode("\n", $content[0]);
$temp = explode(" ", $contentTicks[0]);
$question = "1";
$sum = 0;
$answer = "";
//iterate through all marks and sum
for($i = 0; $i < sizeOf($contentTicks)-1; $i++)
{
	$temp = explode(" ", $contentTicks[$i]);
	if($question == $temp[1])
	{
		if($temp[0] == "tick")
		{
			$sum = $sum +1;
		}
		else if($temp[0] == "half")
		{
			$sum = $sum +0.5;
		}
	}
	else if($question != $temp[1])
	{
		$answer = $answer.'+'.$sum;

		$question = $question +1;
		$sum = 0;
		if($temp[0] == "tick")
		{
			$sum = $sum +1;
		}
		else if($temp[0] == "half")
		{
			$sum = $sum +0.5;
		}
	}
}
$answer = $answer.'+'.$sum;
echo $answer;
?>