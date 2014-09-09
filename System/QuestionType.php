<?php
$num = $_REQUEST["q"];
for($x=0; $x<$num; $x++)
{
	$count = $x+1;
	echo '<div class=""table-responsive><table class="table"><tbody><tr>';
	echo '<th>Question '.$count;
	echo '</th><th><select class="form-control" name=q'.$count;
	echo '><option value=knowledge>Knowledge</option><option value=comprehension>Comprehension</option><option value=Application>Application</option><option value=analysis>Analysis</option><option value=synthesis>Synthesis</option><option value=evaluation>Evaluation</option></select></th>';
	echo '</tr></tbody></table></div>';
}
?>