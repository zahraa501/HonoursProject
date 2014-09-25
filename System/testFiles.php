<?php
$sent = explode("*", $_REQUEST["q"]);
$user= $sent[0];
$info =$sent[1];
$info = explode("/", $info);
$Course = $info[0];
$Test = $info[1];
echo '  <div class="row">
            <div class="page-header">
				<div class="row" width="100%">
					<div class="col-lg-5" width="100%">
						<h4><a href="#"> '.$Course.'</a><font color="#E8E8E8">   /  </font><font color="grey">'.str_replace("_", " ",$Test).'</font></h4>
					</div>
					<div class="text-right">
					<div class="col-xs-6 .col-sm-3" width="100%">
						 
						<p>
							<i class="btn btn-success btn-circle disabled" ><i class="fa fa-check" ></i></i>&nbsp;<font color="grey">Marked Script</font>&nbsp;
							<i class="btn btn-warning btn-circle disabled"><i class="glyphicon glyphicon-bookmark"></i></i>&nbsp;<font color="grey">Saved Script</font>&nbsp;
							<i class="btn btn-danger btn-circle disabled"><i class="glyphicon glyphicon-edit"></i></i>&nbsp;<font color="grey">Unmarked Script</font>&nbsp;
						</p>
						</div>
					</div>
				</div>
            </div>
                <!-- /.col-lg-12 -->
        </div>';
        
            
	echo'<!-- /.row -->
		
						
		<div class="row">
			
			<div class="col-lg-12">
			  
				<!-- .panel-heading -->
				<div class="panel-body">';
						
echo '<div class="table-responsive"><table class="table table-hover">
<thead><tr><th>Status</th><th>Filename</th><th>Marked By</th><th>Last Modified</th></tr></thead>
<tbody>';
//$output = shell_exec("ls /home/zmathews/Honours_Project/".$Course."/".str_replace(" ","_",$Test)."/");
foreach (glob("Files/".$Course."/".str_replace(" ","_",$Test)."/*") as $name) 
{
	if(is_dir($name))
	{	
		$name = explode("/", $name);
		
		
		if(file_exists('Files/'.$Course.'/'.str_replace(" ","_",$Test).'/'.$name[3]."/marks.txt")== 1)
		{
			if(strlen($name[3])<11)
			{
				echo '<tr><td> <i class="btn btn-success btn-circle disabled" ><i class="fa fa-check"></i></i>&nbsp;</td><td><a>'.strtoupper($name[3]).'</a></td><td></td><td></td></tr>';
		
			}
			else
			{
				$display = explode("-",$name[3]);
				$displayName = $display[0].'-'.str_replace("_", " ", $display[1]);
				echo '<tr><td> <i class="btn btn-warning btn-circle disabled"><i class="glyphicon glyphicon-bookmark"></i></i>&nbsp;</td>';
				echo '<td><a href="Editor.php?q='.$user.'*/'.$Course.'/'.str_replace(" ","_",$Test).'/'.$name[3].'/page2.png">'.$displayName.'</a></td><td></td><td></td></tr>';
		
		}
			
		}
		else
		{
			$display = explode("-",$name[3]);
			$displayName = $display[0].'-'.str_replace("_", " ", $display[1]);
			echo '<tr><td> <i class="btn btn-danger btn-circle disabled" ><i class="glyphicon glyphicon-edit"></i></i>&nbsp;</td>';
			echo '<td><a href="Editor.php?q='.$user.'*/'.$Course.'/'.str_replace(" ","_",$Test).'/'.$name[3].'/page2.png">'.$displayName.'</a></td><td></td><td></td></tr>';
		
		}
		
		
	}
}
echo '</div></div></div></div>';
?>