<?php
$con=mysqli_connect("localhost:3306","root","Changmin88","honours_project");
$student = $_REQUEST["q"];
$marks = array();
$test = array();
$getResults= mysqli_query($con,"SELECT * FROM script WHERE StudentNumber='".$student."'");						
while($rows = mysqli_fetch_array($getResults))
{
	$marks[] = $rows['Mark'];
	$test[] = $rows['Test'];
}
$count = 0;
/*for($i =0; $i< sizeOf($test); $i++)
{
	$getTotal= mysqli_query($con,"SELECT Course, Name FROM test WHERE testID='".$test[$i]."'");						
	while($total = mysqli_fetch_array($getTotal))
	{
		$content = file_get_contents("Files/".$total['Course']."/".str_replace(" ", "_",$total['Name'])."/reformattedEndMarkers.txt");
		$content = explode("<split_marker>", $content);
		$mark = explode("\n", $content[0]);
		$totalMark = trim($mark[0]);
		$sum = $sum + (($marks[$i]/$totalMark)*100);
	}
}*/
echo '<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title" id="myModalLabel">'.$student.'</h4>
			</div>
			<div class="modal-body">';
			echo '
			<div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Course</th>
                                            <th>Test</th>
                                            <th>Mark</th>
                                        </tr>
                                    </thead>
                                    <tbody>';                                       
								foreach($test as $one)
								{
									$information= mysqli_query($con,"SELECT Course, Name FROM test WHERE testID='".$one."'");						
									while($info = mysqli_fetch_array($information))
									{
										$content = file_get_contents("Files/".$info['Course']."/".str_replace(" ", "_",$info['Name'])."/reformattedEndMarkers.txt");
										$content = explode("<split_marker>", $content);
										$mark = explode("\n", $content[0]);
										$totalMark = trim($mark[0]);
										echo '<tr><td>'.$info['Course'].'</td><td>'.$info['Name'].'</td><td>'.number_format((($marks[$count]/$totalMark)*100),1).'%</td></tr>';
									}
									$count++;
								}
								echo'        </tbody>
                                </table>
                            </div>';
	echo'		</div>
		</div>
		<!-- /.modal-content -->
	</div>';

//$sum = $sum/sizeOf($test);
//echo $sum.'<br>';
//echo "Total: ".$sum;
//echo '<tr class="gradeA odd" data-toggle="modal" data-target="#myModal" onClick="changeInformation(\''.$row['StudentNumber'].'\')"><td class="sorting_1">'.$row['StudentNumber'].'</td>
//<td class="center ">'.(($sum/sizeOf($test))*100).'</td></tr>';	

?>