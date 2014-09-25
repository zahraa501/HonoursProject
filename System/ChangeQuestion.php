<?php
$info = explode("/",$_REQUEST["q"]);
$filePath = 'Files/'.$info[0].'/'.$info[1].'/'.str_replace(" ","+",$info[2]).'/';
$pageNum = $info[3];
//number of files
$fileCount = 0;
//change to extention name
$directory = new DirectoryIterator($filePath);
foreach($directory as $file ){

	//checks is the file is an image	
	if(substr($file,0,4) == "save")
	{
		$fileCount = $fileCount +1;
	}
}


//start of navigation
echo '<ul class="pagination pagination-lg">';
//back button
if($pageNum >2)
{
	echo '<li><a onclick="changePage(\''.$filePath.'save'.($pageNum-1).'.png\')" >«</a></li>';
}
else
{
	echo '<li class="disabled"><a href="#">«</a></li>';
}
//numbered buttons
for($num = 2; $num <$fileCount+2; $num++)
{
	//button that page is on
	if(strcmp($pageNum,$num) == 0)
	{
		echo '<li class="active"><a onclick="changePage(\''.$filePath.'save'.$num.'.png\')">'.($num-1).'<span class="sr-only">(current)</span></a></li>';
	}
	else
	{
		echo '<li><a onclick="changePage(\''.$filePath.'save'.$num.'.png\')" class="active">'.($num-1).'</a></li>';
	}
}
//next button
if($pageNum <= $fileCount)
{
	echo '<li><a onclick="changePage(\''.$filePath.'save'.($pageNum+1).'.png\')">»</a></li>';
}
else
{
	echo '<li class="disabled"><a href="#">»</a></li>';
}
echo '</ul>';
?>