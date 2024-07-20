<?php
session_start();

if(!isset($_SESSION['username'])){

    header('Location: /acc/login.php');

}

if($_POST) {

    $uname = $id;
	$description = htmlspecialchars($_POST['description']);
	$title = urlencode($_POST['title']);
	$time = date('Y-m-d');
		
    $handle = fopen("../com/posts/" . $title . '.xml', "a");
	fwrite($handle, "<code><title>" . $title . "</title><post>" . $description . "</post><uname>" . $uname . "</uname><date>" . $time . "</date></code>");
	fclose($handle);

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>GR8BRIK community forums</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
</head>
<body class="w3-light-blue w3-container">
    <?php include '../navbar.php' ?>
    <center>
        <h1>Post</h1>
        <form method="post" action="">
		
			<p>
				<label for="title">title:</label>
				<input type="text" class="w3-input" name="title" placeholder="title" size="50" required style="width:30%"/>
			</p>
            <p>
				<label for="description">description:</label><br />
				<textarea name="description" placeholder="description" rows="4" cols="50" required></textarea>
			</p>
			<br/>
			<p><input type="submit" value="post topic" name="post" class="w3-btn w3-blue w3-hover-opacity" /></p>
			<p><button class="w3-btn w3-round w3-hover-opacity" onclick="history.go(-1)">go back</button></p>

        </form>
    </center><br /><br />
    
    <?php include('../linkbar.php'); ?>

</body>
</html>