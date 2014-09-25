<?php
$conn =mysqli_connect("localhost:3306","root","Changmin88","honours_project");
									
$result = mysqli_query($conn,"SELECT Course,Date,Name FROM test");					
$answer = "";
while($rs = mysqli_fetch_array($result)) 
{
    $answer = $answer.'{Title:"'  . $rs["Course"] .': '.$rs["Name"].'",Start:"'   . $rs["Date"] . '"},'; 
}

$conn->close();

echo($answer);
?>