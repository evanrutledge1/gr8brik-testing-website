<?php
	session_start();
	require_once 'classes/membership.php';
	$Membership = new Membership();
	
	if(isset($_GET['status']) && $_GET['status'] == 'loggedout') {
		$Membership->log_User_Out();
	}
	
	if($_POST && !empty($_POST['username']) && !empty($_POST['pwd'])) {
		$response = $Membership->validate_User($_POST['username'], $_POST['pwd']);
		
	}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Login - GR8BRIK</title>
    <link rel="stylesheet" href="../w3.css">
</head>
<body class="w3-container w3-light-blue">
	<?php include '../navbar.php'; ?>
	<script>
		function showPass() {
			var x = document.getElementById("pwd");
			if (x.type === "password") {
				x.type = "text";
			} else {
				x.type = "password";
			}
		}
        $(document).ready(function() {
			$("#alert").fadeOut(10000);
			$("#close").click(function(){
				$("#alert").hide();
			});
        });
    </script>
    <center>
        <div class="main">
			<form method="post" action="">
				<h1>Login</h1> 
				<small>Please logon to continue</small>
				<p>
					<label for="username">username:</label>
					<input type="text" class="w3-input" name="username" required style="width:30%"/>
				</p>
				<p>
					<label for="pwd">password:</label>
					<input type="password" class="w3-input" name="pwd" id="pwd" required style="width:30%"/>
					<input type="checkbox" class="w3-check" onclick="showPass();">
					<label class="w3-validate">show</label>
				</p>
				<p>
					<input class="w3-btn w3-blue w3-hover-opacity" type="submit" id="submit" value="login" name="submit" />
			</form>
			<a href="register.php">Register</a>
			<?php if(isset($response)) echo "<h4 class='alert w3-padding w3-red' id='alert'>" . $response . "<button class='close w3-btn w3-blue w3-hover-opacity' id='close'>okay</button></h4>"; ?>
        </div>
    </center>
</body>
</html>