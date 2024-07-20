<?php

require_once 'classes/membership.php';
$membership = New Membership();

$membership->confirm_Member();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <center>
        <div class="main">
            <h1>Page</h1>
			<a href="login.php?status=loggedout">Log out</a>
        </div>
    </center>
</body>
</html>