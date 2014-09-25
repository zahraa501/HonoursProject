<?php
$info = explode(" , ",$_REQUEST["q"]);
$course = $info[0];
$test = $info[1];
$con=mysqli_connect("localhost:3306","root","Changmin88","honours_project");
//get information about test
$content = file_get_contents("Files/".$course."/".str_replace(" ","_",$test)."/reformattedEndMarkers.txt");
$content = explode("<split_marker>", $content);
$marks = explode("\n", $content[0]);
$totalMark = trim($marks[0]);
$questionMark = array();
for($i = 1; $i<sizeOf($marks)-1; $i++)
{
	$temp = explode("[",$marks[$i]);
	$questionMark[] = str_replace(" marks]", "", $temp[1]);
}

//get marks from student
$getQuestionTypes = "";
$testID = "";
$test = mysqli_query($con,"SELECT testID, TypeOfQuestions FROM test WHERE Course='".$course."' AND Name='".$test."'");						
while($row = mysqli_fetch_array($test))
{
	$testID = $row['testID'];
	$getQuestionType = $row['TypeOfQuestions'];
	
}
$studentMarks = array();
$studentQuestionMarks = array();
$scripts = mysqli_query($con,"SELECT * FROM script WHERE Course='".$course."' AND Test=".$testID."");						
while($row = mysqli_fetch_array($scripts))
{
	$studentMarks[] = $row['Mark'];
	$studentQuestionMarks[] = $row['Results'];
}
$numFiles = -1;
foreach (glob("Files/CSC4000W/Test_1/*") as $name) 
{
	
	$numFiles  = $numFiles +1;
}
$first = 0;
$usecond = 0;
$second = 0;
$third = 0;
$fail = 0;
$absent = 0;

foreach($studentMarks as $mark)
{
	if(($mark/$totalMark)*100 >= 75)
	{
		$first++;
		//echo 'First: '.($mark/$totalMark)*100;
	}
	else if(($mark/$totalMark)*100 < 75 and ($mark/$totalMark)*100 >= 70)
	{
		$usecond++;
		//echo 'Second: '.($mark/$totalMark)*100;
	}
	else if(($mark/$totalMark)*100 < 70 and ($mark/$totalMark)*100 >= 60)
	{
		$second++;
		//echo 'LSecond: '.($mark/$totalMark)*100;
	}
	else if(($mark/$totalMark)*100 < 60 and ($mark/$totalMark)*100 >= 50)
	{
		$third++;
		//echo 'Third: '.($mark/$totalMark)*100;
	}
	else if(($mark/$totalMark)*100 < 50 )
	{
		$fail++;
		//echo 'Fail: '.($mark/$totalMark)*100;
	}
}
$count = 0;
$getStudents = mysqli_query($con,"SELECT DISTINCT StudentNumber FROM registered_students WHERE Course='".$course."'");						
while($row = mysqli_fetch_array($getStudents))
{
	$count++;
}
$absent = $count- ($fail+$third+$second+$usecond+$first) -$numFiles;
$unmarked = $numFiles - ($fail+$third+$second+$usecond+$first);
if($absent < 0)
{
	$absent =0;
}
$answer = $unmarked.";".$absent.";".$fail.";".$third.";".$second.";".$usecond.";".$first.'*'.$getQuestionType.'*';
$tempMarks = array();
$amountOfQuestions = 0;
$amountOfStudents = sizeOf($studentMarks); 
foreach($studentQuestionMarks as $student)
{
	$temp = explode("+", $student);
	$amountOfQuestions = sizeOf($temp) -1;
	for($i = 1; $i <sizeOf($temp); $i++)
	{
		$tempMarks[] = $temp[$i];
		//echo $sumMarks[$i];// = $sumMarks[$i] + $temp[$i+1];
	}	
}
$sumQuestion = array();
for($i = 0 ; $i <$amountOfQuestions; $i++)
{
	$sum = 0;
	for($j = $i ; $j <sizeOf($tempMarks); $j = $j + $amountOfQuestions)
	{
		$sum = $sum +  $tempMarks[$j];
	}
	$sumQuestion[] = (($sum/$amountOfStudents)/$questionMark[$i])*100;
}
foreach($sumQuestion as $one)
{
	$answer = $answer.number_format($one,0).'+';
}

echo '<script>	window.onload = function(){var ctx = document.getElementById("BarChart").getContext("2d");
					var data = {
						labels: ["Question"],
						datasets: [';
			$getQuestionType =explode("+", $getQuestionType);
					
							for($i = 0; $i < sizeOf($sumQuestion); $i++)
							{
								$color = "";
								if(trim($getQuestionType[$i+1]) == "knowledge")
								{
									$color ="rgba(178,0,255,0.8)";
								}
								else if(trim($getQuestionType[$i+1]) == "comprehension")
								{
									$color ="rgba(107,198,225,0.8)";
								}
								else if(trim($getQuestionType[$i+1]) == "application")
								{
									$color ="rgba(92,184,92,0.8)";
								}
								else if(trim($getQuestionType[$i+1]) == "analysis")
								{
									$color ="rgba(255,219,73,0.8)";
								}
								else if(trim($getQuestionType[$i+1]) == "evaluation")
								{
									$color ="rgba(255,153,51,0.8)";
								}
								else if(trim($getQuestionType[$i+1]) == "synthesis")
								{
									$color ="rgba(217,83,79,0.8)";
								}
								if($i < sizeOf($sumQuestion)-1)
								{
									echo'{label: "Question '.($i+1).'",
									fillColor: "rgba(225,225,225,0)",
									strokeColor: "'.$color.'",
									highlightFill: "rgba(225,225,225,0)",
									highlightStroke: "'.$color.'",
									data: ['.number_format($sumQuestion[$i],0).']},';
								}
								else
								{
									echo'{label: "Question '.($i+1).'",
									fillColor: "rgba(225,225,225,0)",
									strokeColor: "'.$color.'",
									highlightFill: "rgba(225,225,225,0)",
									highlightStroke: "'.$color.'",
									data: ['.number_format($sumQuestion[$i],0)	.']}';
								}
							}
							
echo'						]
					};


					var myBarChart = new Chart(ctx).BarOneTip(data, {
							//responsive : true,
							multiTooltipTemplate: "<%= datasetLabel %> - <%= value %>"
						});}';
mysqli_close($con);		
?>