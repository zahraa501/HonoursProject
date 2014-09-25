<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Core CSS - Include with every page -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- SB Admin CSS - Include with every page -->
    <link href="css/sb-admin.css" rel="stylesheet">

</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
                    <div class="panel-body">
                        <form>
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Username" id="username" type="text" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" id="password" type="password" value="">
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <a onclick="check()" class="btn btn-lg btn-success btn-block">Login</a>
                            </fieldset>
							<div id="notAccepted"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Core Scripts - Include with every page -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <!-- SB Admin Scripts - Include with every page -->
    <script src="js/sb-admin.js"></script>
	<script>
		function check()
		{
			var info = document.getElementById("username").value+"+"+document.getElementById("password").value;
			var xmlhttp=new XMLHttpRequest();
			xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
				var response = xmlhttp.responseText;
					
					if(response == 1)
					{
						 window.location="Home.php?q="+document.getElementById("username").value;
					}
					else
					{
						document.getElementById("notAccepted").innerHTML = response;
					}
				}
			}
			  xmlhttp.open("GET","loginCheck.php?q="+info,true);
			  xmlhttp.send();
		}
	</script>
</body>

</html>
