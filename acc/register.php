<?php
session_start();
require_once 'classes/membership.php';
$Membership = new Membership();

if ($_POST && !empty($_POST['username']) && !empty($_POST['pwd']) && !empty($_POST['email'])) {
    $response = $Membership->register_User($_POST['username'], $_POST['pwd'], $_POST['email']);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Register</title>
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
                <h1>Register</h1>
                <small>Please fill in the details to create an account</small>
                <p>
                    <label for="username">username:</label>
                    <input type="text" name="username" class="w3-input" required style="width:30%"/>
                </p>
                <p>
                    <label for="email">e-mail:</label>
                    <input type="email" name="email" class="w3-input" required style="width:30%"/>
                </p>
                <p>
                    <label for="pwd">password:</label>
                    <input type="password" name="pwd" id="pwd" class="w3-input" required style="width:30%"/>
                    <input type="checkbox" class="w3-check" class="w3-input" onclick="showPass();">
					<label class="w3-validate">show</label>
                </p>
                <p>
                    <input class="w3-btn w3-blue w3-hover-blue" type="submit" id="submit" value="register" name="submit" />
                </p>
            </form>
			<a href="login.php">Login</a><br />
			<b>By registering, you accept the <a href="../rules.php">Rules</a>.</b>
            <?php if (isset($response)) echo "<h4 class='alert'>" . $response . "</h4>"; ?>
        </div>
    </center>
    <script>
        function showPass() {
            var x = document.getElementById("pwd");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
</body>
</html>
