<?php
$tick = $_REQUEST["q"];
echo '<script src="tooltips.js"></script>';
if($tick == "half")
{
echo '<button type="button" value="false" class="btn btn-default" id="tick" onclick="tick()"><span class="glyphicon glyphicon-ok" data-toggle="tooltip" 
					data-placement="bottom" title="Tick Annotation"></span></button>';
echo '<button type="button" value="true" class="btn btn-default active" id="half" onclick="half()" data-toggle="tooltip" 
					data-placement="bottom" title="Half-tick Annotation"><span> <img src="Images/half-tick.png" width="15px" height="15px"/></span></button>';	
echo '<button type="button" class="btn btn-default" onclick="undo()" data-toggle="tooltip" 
					data-placement="bottom" title="Undo"><span class="glyphicon glyphicon-repeat"></span></button>';
echo '<button class="btn btn-default" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-flag"></span></button>';
}
else if($tick == "tick")
{
echo '<button type="button" value="true" class="btn btn-default active" id="tick" onclick="tick()" data-toggle="tooltip" 
					data-placement="bottom" title="Tick Annotation"><span class="glyphicon glyphicon-ok"></span></button>';
echo '<button type="button" value="false" class="btn btn-default" id="half" onclick="half()" data-toggle="tooltip" 
					data-placement="bottom" title="Half-tick Annotation"><span> <img src="Images/half-tick.png" width="15px" height="15px"/></span></button>';		
echo '<button type="button" class="btn btn-default" onclick="undo()" data-toggle="tooltip" 
					data-placement="bottom" title="Undo"><span class="glyphicon glyphicon-repeat"></span></button>';
echo '<button class="btn btn-default" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-flag"></span></button>';
}

?>