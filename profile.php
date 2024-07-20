<?php

session_start();

require_once 'acc/classes/constants.php';

include $_SERVER['DOCUMENT_ROOT'] . '/gr8brik/gr8brik-assets/acc/classes/user.php';

// Create connection
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$profile_id = $_GET['user'];
$sql = "SELECT id, username, email, admin FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $profile_id);
$stmt->execute();
$stmt->store_result();

$stmt->bind_result($profile_id, $profile_user, $profile_mail, $profile_admin);
$stmt->fetch();

if ($profile_user === "" || $stmt->num_rows === 0) {
	$profile_user = '[deleted]';
}

if(isset($_POST['ban'])) {
	
	$profile_id = $_GET['user'];
	$profile_user = "";
	
	$sql = "UPDATE users SET username = ? WHERE id = ?";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param("ss", $profile_username, $profile_id);
	$stmt->execute();
	$stmt->close();
	$conn->close();
	die;
}
if(isset($_POST['unban'])) {
	
	$profile_id = $_GET['user'];
	
	$sql = "UPDATE users SET username = ? WHERE id = ?";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param("ss", $profile_mail, $profile_id);
	$stmt->execute();
	$stmt->close();
	$conn->close();
	die;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>View <?php echo $profile_user ?>'s profile</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <meta charset="UTF-8">
    <meta name="description" content="Gr8brik is a block building browser game. No download required">
    <meta name="keywords" content="legos, online block builder, gr8brik, online lego modeler, barbies-legos8885 balteam, lego digital designer, churts, anti-coppa, anti-kosa, churtsontime, sussteve226, manofmenx">
    <meta name="author" content="sussteve226">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
</head>
<body class="w3-container w3-light-blue">

<?php 
    include('navbar.php');
?>
        <?php
        ?>
            <img src="<?php echo 'acc/users/pfps/' . $profile_id . '..jpg' ?>" style='width: 250px; height: 250px; border-radius: 50%;cursor:zoom-in' class="w3-hover-opacity" onclick="document.getElementById('im').style.display='block'" />
			
			<div id="im" class="w3-modal w3-center" onclick="this.style.display='none'">

                <span class="w3-closebtn w3-red w3-hover-white w3-padding w3-display-topright">&times;</span>

                <img class="w3-modal-content" src="<?php echo 'acc/users/pfps/' . $profile_id . '..jpg' ?>" style="width:75%;" loading="lazy">

            </div>

            <div class='user'>
                <b style="font-size:30px;"><?php echo $profile_user; ?></b><br />
				<?php
				
				if($profile_admin === 1) {
					echo '<div title="this user is an admin of gr8brik"><img src="img/star.jpg" style="width:20px;height:20px;border-radius:50px;"><b style="font-size:20px;">admin</b></div><br />';
				}
				
				?>
            </div>
			
			<div class="w3-topnav w3-large w3-card-24 w3-border w3-black">
				<a href="#creations">creations</a>
				<a href="#posts">posts</a>
				<a href="#comments">comments</a>
			</div><br />
			<?php
			if ($profile_user === "[deleted]" || $stmt->num_rows === 0) {
				// User does not exist
				echo '<b>this account does not exist</b><br />';
					if($admin === 1) {
						echo '<form action="" method="post">';
						echo '<input type="submit" value="restore user (if email exists)" name="unban"></form>';
					}
				die;
			} else {
				if($admin === 1) {
					echo '<form action="" method="post"><input type="submit" value="ban user" name="ban"></form>';
				}
			}
			?>
			<a id="creations">
				<h3>creations</h3>
				<div class="w3-row">
				<?php

				$query = $_GET['user'];
                foreach (glob("cre/*json") as $_FF) {
                    if (strpos($_FF, $query) !== false) {
						echo "<div class='w3-display-container w3-half w3-none w3-card-24 w3-hover-opacity'>";
                        echo "<a href='creation.php?" . $_FF . "'>";
						echo "<img src='img/blured_model.jpg' style='width:33vw;height:33vh;'></a>";
                        echo "<br /><b style='color:#000;' class='w3-display-middle'>" . $_FF . "</b></div>";
					}
                };

            ?>
			</div>
			</a><hr />
			<a id="posts">
				<h3>posts</h3>
				<div class="w3-row">
				<?php

                $query = $_GET['user'];
                foreach (glob("com/posts/*xml") as $_FF) {
                    if (strpos($_FF, $query) !== false) {
						echo "<div class='w3-display-container w3-half w3-none w3-card-24 w3-hover-opacity'>";
                        echo "<a href='com/view.php?" . $_FF . "'>";
						echo "<img src='img/com.jpg' style='width:33vw;height:33vh;'></a>";
						echo "<br /><b style='color:#000;' class='w3-display-middle'>" . $_FF . "</b></div>";
					}
                };

            ?>
			</div>
			</a><br /><hr />
			<a id="comments">
				<h3>comments</h3>
				<b>Coming to profile pages soon!</b>
			</a><hr />
			<br /><br />
			
	<?php $stmt->close(); $conn->close(); ?>

    <?php include('linkbar.php') ?>


</div>

</body>
</html>