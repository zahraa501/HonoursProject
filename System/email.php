<html>
<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Demo</title>
</head>
<body>
<h1>Email Test</h1>
 <?php
    $from = $_POST["from"]; // sender
    $subject = "test mail server";
    $message = "This will be the body of the email.";
    // message lines should not exceed 70 characters (PHP rule), so wrap it
    $message = wordwrap($message, 70);
    // send mail
    mail("zahraa.mathews@gmail.com",$subject,$message,"From: $from\n");
    echo "Thank you for sending us feedback";
?>
</body>
</html>