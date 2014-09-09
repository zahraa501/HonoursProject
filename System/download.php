<html>
<head>
<script type="text/javascript">
function loadXMLDoc(str)
{
    var xmlhttp;
    if (window.XMLHttpRequest)
    {
        xmlhttp = new XMLHttpRequest();
    }
    else
    {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function()
    {
        if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","DownloadFile.php?q="+str,true);
    xmlhttp.send();
}
</script>
</head>
<body>
<?php 
$names[]= 'Mary';
//$names[]= 'Sally';
//$names[]= 'James';
//$names[]= 'Tom';

foreach($names as $name)
{
	echo '<a href=# onclick=loadXMLDoc("XXNMAT009.pdf") >click me</a><br>';
}
?>
<!--<a href="#" onclick="loadXMLDoc('something')" >click to call function</a>-->
<br>
<span id="txtHint"></span>
</body>
</html>