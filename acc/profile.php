<?php

session_start();

require_once 'classes/constants.php';

// Create connection
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$id = $_GET['user'];
$sql = "SELECT id, username, email, age, handle, admin FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($id, $user, $mail, $age, $at, $mod);
    $stmt->fetch();
    // User exists, you can now use the fetched data
} else {
    // User does not exist
    echo '404 user not in database';
	die;
}

$stmt->close();
$conn->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>User profile</title>
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
    include('../navbar.php') 
?>
        <?php
        ?>
            <img src="<?php echo 'users/pfps/' . $id . '..jpg' ?>" style='width: 250px; height: 250px; border-radius: 50%;cursor:zoom-in' class="w3-hover-opacity" onclick="document.getElementById('im').style.display='block'" />
			
			<div id="im" class="w3-modal w3-center" onclick="this.style.display='none'">

                <span class="w3-closebtn w3-white w3-hover-red w3-padding w3-display-topright">&times;</span>

                <img class="w3-modal-content" src="<?php echo 'users/pfps/' . $id . '..jpg' ?>" style="width:75%;" loading="lazy">

            </div>

            <div class='user'>
                <b style="font-size:30px;"><?php echo "Username:" . $user;?></b><br />
				<b style="font-size:30px;"><?php echo "Handle:@" . $at;?></b><br />
				<?php
				
				if($mod == "yes") {
					echo '<img src="../img/star.jpg" width="20px" height="20px" title="Admin rank"><b style="font-size:20px;">Admin rank</b><br />';
				}
				
				?>
            </div><br /><br />
			
	<?php $stmt->close(); $conn->close(); ?>

    <?php include('../linkbar.php') ?>


</div>

</body>
</html>