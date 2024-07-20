<?php

session_start();

		// Define constants here

		define('DB_NAME2', 'creations');
		include 'acc/classes/constants.php';

if(isset($_POST['comment'])){
	
	$comment = $_POST['commentbox'];


		// Create connection
		$conn = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME2);
			
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
			
		// Query to get creation by it's own ID
		$id = $_GET['id'];

		$sql = "SELECT id, user, model, description, name FROM model WHERE id = ?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$stmt->store_result();
		
		$stmt->bind_result($id, $user, $model, $description, $name);
		$stmt->fetch();
		
		// Create connection
		$conn = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);
			
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		
		$session = $_SESSION['username'];
		$sql = "SELECT id FROM users WHERE id = $session";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			$username = $row['id'];
		}
		
		// Create connection
		$conn = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME2);
			
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		
		$sql = "INSERT INTO comments (user, model, comment) VALUES (?, ?, ?)";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("sss", $user, $id, $comment); // Assuming 'user' and 'model' are strings
		$stmt->execute();
	
}

include('com/bbcode.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>GR8BRIK model</title>

    <meta charset="UTF-8">
    <meta name="author" content="sussteve226">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body class="w3-light-blue w3-container">

<?php include('navbar.php') ?>

        <?php 
		
		// Create connection
		$conn = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME2);
			
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
			
		// Query to get creation by it's own ID
		$id = $_GET['id'];

		$sql = "SELECT id, user, model, description, name FROM model WHERE id = ?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$stmt->store_result();
		
		$stmt->bind_result($id, $user, $model, $description, $name);
		$stmt->fetch();
				
		// Create connection
		$conn = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);
			
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		
		$sql = "SELECT username FROM users WHERE id = $user";
		$result = $conn->query($sql);
			
		if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			$username = $row['username'];
		}
		
		echo "<h1>" . $name . "</h1>";
		
		echo '<table style="width:25vw;height:10vh;" class="w3-table-all w3-card-24"><td><h3><img src="acc/users/pfps/' . $user . '..jpg" style="width:50px;height:50px;border-radius:50px;">by <a href="profile.php?user=' . $user . '">' . $username . '</a></h3></td></table><br />';
		
		?>
		
		<div class="<?php echo $model ?>">
			<iframe src="<?php echo "embed.php?model=" . $model . "&login=" . $_SESSION['username']?>" style="width:70vw;height:50vh;border:1px solid;border-radius:15%;" id="<?php echo $id ?>" title="<?php echo $model ?>">
				<b>error loading model "<?php echo $model ?>"</b>
			</iframe>
		</div>
		
			<button onclick="document.getElementById('report').style.display='block'" name="flag" class="w3-btn w3-red w3-hover-opacity" />flag...</button>
			<div id="report" class="w3-modal">
				<div class="w3-modal-content w3-animate-top w3-card-24 w3-black w3-center">
					<div class="w3-container">
					
						<span onclick="document.getElementById('report').style.display='none'" class="w3-closebtn w3-red w3-hover-white w3-padding w3-display-topright">&times;</span>
						
						<form method="post" action="report_test.php">
							
							<b>Why do you want to flag this creation?</b><br />
							<input type="checkbox" name="type" class="w3-check">
							<label class="w3-validate" value="Volent">Volent</label><br />
							
							<input type="checkbox" name="type" value="False info" class="w3-check">
							<label class="w3-validate">False info</label><br />
							
							<input type="checkbox" name="type" value="Spicy content" class="w3-check">
							<label class="w3-validate">Spicy content</label><br />
							
							<input type="checkbox" name="type" value="Harrasing me" class="w3-check">
							<label class="w3-validate">Harrasing me</label><br />
							
							<input type="checkbox" name="type" value="Something else" class="w3-check" onclick="document.getElementById('other').style.display='block';document.getElementById('hide').style.display='block'">
							<label class="w3-validate">Something else</label><br /><br />
							
							<b>Checks:</b><br />
							<input type="text" value="<?php echo $username ?>" name="user" readonly><br />
							<input type="text" value="<?php echo $id ?>" name="id" readonly><br /><br />
							
							<center><textarea style="display:none;" class='w3-card-24' name="other" id='other' placeholder='Expain more...' rows='4' cols='50'></textarea><input type="checkbox" class="w3-check" id="hide" style="display:none;" onclick="document.getElementById('other').style.display='none'"><label class="w3-validate">hide</label><br /></center>
							<button name="close" onclick="document.getElementById('report').style.display='none';document.getElementById('hide').style.display='none'">close</button> 
							<input type="submit" value="report" name="report">
						</form>
					</div>
				</div>
			</div>
			<a href="<?php echo 'cre/' . $model . '.json' ?>" class='w3-btn w3-blue w3-hover-opacity' download>download</a>
			<br /><b>EMBED:<input type="text" class="w3-input" value=<?php echo "http://gr8brik.rf.gd/embed.php?model=" . $model . "&login=" . $_SESSION['status'] ?> style="width:50%;height:25%;"></b>
		
		<br /><form method='post' action=''><textarea class='w3-card-24' name='commentbox' placeholder='Add a comment...' rows='4' cols='50'></textarea><br /><input type='submit' value='post' name='comment' class='w3-btn w3-blue w3-hover-opacity' /><altcha-widget challengeurl='https://eu.altcha.org/api/v1/challenge?apiKey=ckey_01d9f4ad018c16287ca6f3938a0f' style='background-color:white!important;'></altcha-widget></form>
			
		<hr /><h3>comments</h3><br />
			
		<?php 
			// Create connection
			$conn = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME2);
			
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}
		
			$sql = "SELECT id, user, model, comment FROM comments WHERE model = $id";
			$comResult = $conn->query($sql);
			
			while ($row = $comResult->fetch_assoc()) {
			
				$c_id = $row['id'];
				$c_user = $row['user'];
				$c_model = $row['model'];
				$c_comment = $row['comment'];
			
				// Create connection
				$conn = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);
			
				if ($conn->connect_error) {
					die("Connection failed: " . $conn->connect_error);
				}
		
				$sql = "SELECT username FROM users WHERE id = $c_user";
				$userResult = $conn->query($sql);
			
				$userRow = $userResult->fetch_assoc();
				$c_username = $userRow['username'];
				if ($c_username === "" || $userResult->num_rows === 0) {
					$c_username = "[deleted]";
				}
			
				echo '<table id="' . $c_id . '" class="w3-table-all w3-card-24 w3-round">';
				echo '<tr><td style="float:left;"><img src="acc/users/pfps/' . $c_user . '..jpg" style="width:50px;height:50px;border-radius:50px;"></td><td style="float:left;"><h4><a href="profile.php?user=' . $c_user . '">' . $c_username . '</a></h4></td></tr>';
				echo '<tr><td style="float:left;"><h5>' . $c_comment . '</h5></td></tr>';
				echo '</table><br />';
			}

            echo '</div><br /><br />';

            include('linkbar.php');

        ?>

</body>
</html>