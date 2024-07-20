<?php
session_start();

require_once 'classes/constants.php';

// Create connection
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$session = $_SESSION['username'];
$sql = "SELECT id, username, email, alert FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $session);
$stmt->execute();
$stmt->bind_result($id, $user, $mail, $alert);
$stmt->fetch();

if(!isset($_SESSION['username'])){

    header('Location: acc/login.php');

}
if(isset($_POST['upload'])){
    $target_dir = "../cre/";
    $target_file = $target_dir . '(' . $_SESSION['username'] . ')' . basename($_FILES['fileToupload']['name']);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
    $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["fileToupload"]["size"] > 5242880) {
        echo "Sorry, your file is too large.";
    $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "json" && $imageFileType != "js" ) {
        echo "Sorry, only Json and Js files are allowed.";
    $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToupload"]["tmp_name"], $target_file)) {
        echo "The model has been uploaded. View it <a href='http://gr8brik.rf.gd/cre/view.php?". '(' . $_SESSION['username'] . ')' . basename($_FILES['fileToupload']['name']) ."'>here</a>";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
    }
	
	if(isset($_POST['update'])){
		// Create connection
		$conn = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);

		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		$session = $_SESSION['username'];
		$sql = "SELECT id, username, email, age, handle FROM users WHERE username = ?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("s", $session);
		$stmt->execute();
		$stmt->bind_result($id, $user, $mail, $age, $at);
		$stmt->fetch();
		$dir = "../acc/users/pfps/";
		$target_file = $dir . basename($_FILES['fileToupload']['name']);
		$filename = $dir . $id;
		$extension = substr_replace($target_file , 'jpg', strrpos($filename, '.') +1);
		$temp = explode(".", $_FILES["fileToupload"]["name"]);
		$upload = $filename . $extension;
		$okay = 1;

		// Check file size
		if ($_FILES["fileToupload"]["size"] > 5242880) {
			echo "Sorry, your file is too large.";
			$uploadOk = 0;
		}

		// Check if $uploadOk is set to 0 by an error
		if ($okay == 0) {
			echo "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
		} else {
			if (move_uploaded_file($_FILES["fileToupload"]["tmp_name"], $upload )) {
			echo "Your Profile Pricture has been updated.";
		} else {
			echo "Sorry, there was an error uploading your file.";
		}
    }

}

}

$password_error = false;
if($password_error) {
    echo '<b>Some of the passwords do not match</b>';
}
if(isset($_POST['change'])){
    $old = md5($_POST['o_password']);
    $new = md5($_POST['n_password']);
    $confirm = md5($_POST['c_password']);
    if($new == $confirm) {
			// Fetch the current password from the database
			$conn = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);
			$stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
			$username = $_SESSION['username'];
			$stmt->bind_param("s", $username);
			$stmt->execute();
			$stmt->bind_result($db_password);
			$stmt->fetch();
			$stmt->close();
			$hashed_password = $new;
			$stmt_2 = $conn->prepare("update users SET password = ? WHERE username = ?");
            $stmt_2->bind_param("ss", $hashed_password, $username);
            if ($stmt_2->execute()) {
                echo "Password successfully changed!";
            } else {
                echo "Error updating password.";
            }
            $stmt->close();
            header('Location: logout.php');
            die;
        }
    $password_error = true;
}
if(isset($_POST['u_change'])){
    $new = $_POST['username'];
		// Fetch the current password from the database
			$conn = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);
			$stmt = $conn->prepare("SELECT username FROM users WHERE username = ?");
			$username = $_SESSION['username'];
			$stmt->bind_param("s", $username);
			$stmt->execute();
			$stmt->bind_result($at);
			$stmt->fetch();
			$stmt->close();
			$stmt_2 = $conn->prepare("update users SET username = ? WHERE username = ?");
            $stmt_2->bind_param("ss", $new, $username);
            if ($stmt_2->execute()) {
				$_SESSION['username'] = $new;
                echo "Username successfully changed!";
            } else {
                echo "Error updating username.";
            }
            $stmt->close();
            die;
    }
$email_error = false;
if(isset($_POST['e_change'])){
    $old = $_POST['o_email'];
    $new = $_POST['n_email'];
    $confirm = $_POST['c_email'];
    // Fetch the current email from the database
			$conn = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);
			$stmt = $conn->prepare("SELECT email FROM users WHERE username = ?");
			$username = $_SESSION['username'];
			$stmt->bind_param("s", $username);
			$stmt->execute();
			$stmt->bind_result($email);
			$stmt->fetch();
			$stmt->close();
			$stmt_2 = $conn->prepare("update users SET email = ? WHERE username = ?");
            $stmt_2->bind_param("ss", $new, $username);
            if ($stmt_2->execute()) {
                echo "E-mail successfully changed!";
            } else {
                echo "Error updating e-mail.";
            }
            $stmt->close();
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Account - GR8BRIK</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
</head>
<body class="w3-light-blue w3-container">

    <?php include('../navbar.php') ?>

    <div class="w3-center">
        <div class="w3-black w3-card-4">
            <?php 
				if($alert != 0){
					echo '<h1 style="color:red;">You have new notifications!</h1>';
				}
					echo '<h3>Welcome,</h3><h1>' . $_SESSION['username'] . '</h1>';
            ?>
            <h3>or @<?php echo $mail ?><a href="#email"><i class="fa fa-pencil" aria-hidden="true"></i></a></h3>

            <a href="<?php echo '../profile.php?user=' . $id ?>" class="w3-btn w3-large w3-white w3-hover-blue"><li class="fa fa-user" aria-hidden="true"></li><b>profile</b></a>
			<a href="new.php" class="w3-btn w3-large w3-white w3-hover-blue"><i class="fa fa-bell" aria-hidden="true"></i><b>clear new</b></a>
        </div>
		
		<div class="w3-black w3-card-4">

        <h1>Quick settings</h1>

        <a href="logout.php" class="w3-btn w3-blue w3-hover-opacity"><i class="fa fa-sign-out" aria-hidden="true"></i>logout</a>

        <button onclick="toggleDarkMode();" class="w3-btn w3-blue w3-hover-opacity"><i class="fa fa-moon-o" aria-hidden="true"></i>dark mode</button>

        <button onclick="toggleLightMode();" class="w3-btn w3-blue w3-hover-opacity"><i class="fa fa-lightbulb-o" aria-hidden="true"></i>light mode</button>
        
        <script>
            function toggleDarkMode() {
                var element = document.body;
                element.classList.toggle("w3-dark-grey");
                localStorage.setItem("toggleDarkMode", "w3-dark-grey");
            }
            function toggleLightMode() {
                var element = document.body;
                element.classList.toggle("w3-light-blue");
                localStorage.setItem("toggleLightMode", "w3-light-blue");
            }
        </script>
        </div>

        <center>

        <h2 id="upload">Upload model</h2>

        <form action="" method="post" enctype="multipart/form-data">

            <input type="file" name="fileToupload" id="fileToupload" class="w3-input" style="width:30%">

            <input type="submit" name="upload" value="upload" class="w3-btn w3-blue w3-hover-opacity">

        </form><br />

        </center>

        
        <br />
        
		<h1>Settings</h1>
  <h2>Profile picture (no image if none)</h2>
  <center>
  <div>
    <img src="<?php echo '../acc/users/pfps/' . $id . '..jpg' ?>" style="width: 250px; height: 250px; border-radius: 50%;" class="w3-card-8" />
    <form action="" method="post" enctype="multipart/form-data">
    <input type="file" name="fileToupload" id="fileToupload" class="w3-input" style="width:30%" >
    <input type="submit" value="update profile" name="update" class="w3-btn w3-blue w3-hover-opacity">
    </form>
  </div>
  </center>

  <br />

	<h2>Change password</h2>
    <center>
    <form method="post" action="">
    <input type="password" class="w3-input" name="o_password" placeholder="Old password" style="width:30%" />
    <br /><input type="password" class="w3-input" name="n_password" placeholder="New password" style="width:30%" />
    <br /><input type="password" class="w3-input" name="c_password" placeholder="Confirm password" style="width:30%" />
    <br /><input type="submit" name="change" value="update password" class="w3-btn w3-blue w3-hover-opacity" />
    </form>
    </center>
	
	<h2 id="username">Change username</h2>

    <center>
    <form method="post" action="">
    <input type="text" class="w3-input" name="username" placeholder="New username" style="width:30%" />
    <br /><input type="submit" name="u_change" value="update username" class="w3-btn w3-blue w3-hover-opacity" />
    </form>
    </center>


    <h2 id="email">Change email</h2>

    <center>
    <form method="post" action="">
    <br /><input type="text" name="o_email" placeholder="Old email" class="w3-input" style="width:30%" />
    <br /><input type="text" name="n_email" placeholder="New email" class="w3-input" style="width:30%" />
    <br /><input type="text" name="c_email" class="w3-input" placeholder="Confirm email" style="width:30%" />
    <br /><input type="submit" name="e_change" value="update email" class="w3-btn w3-blue w3-hover-opacity" />
    </form>
    </center>

  <br />

		
        <hr />
        <h5>If you wish us to remove any personal details we hold about you, please email us at <i class="fa fa-envelope"></i><a href="mailto:evanrutledge226@gmail.com">evanrutledge226[at]gmail[dot]com</a></h5>
    </div>
    <?php include '../linkbar.php' ?>
</body>
</html>