<?php

session_start();

$p_xml = simplexml_load_file('posts/' . basename($_SERVER['QUERY_STRING']) . '.xml');

$p_xml_2 = new SimpleXMLElement('posts/' . basename($_SERVER['QUERY_STRING']) . '.xml', 0, true);

if(!file_exists('posts/' . basename($_SERVER['QUERY_STRING'] . '.xml'))){

    echo '<b>404 post not in database</b><br />';

    die;

}

if ($p_xml === false) {
				
	die("<b>Can't load post via XML</b>");
	
}
				
	if (trim($p_xml->post) === "") {
				
		die("<b>Post has been removed from database</b><br />");
				
	}
	
if(isset($_POST['comment'])){
	
	require_once '../acc/classes/constants.php';

	// Create connection
	$conn = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);

	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$username = $_SESSION['username'];
	$sql = "SELECT id, username, email, age, handle FROM users WHERE username = ?";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param("i", $username);
	$stmt->execute();
	$stmt->bind_result($id, $user, $mail, $age, $at);
	$stmt->fetch();
	
    if (isset($_SESSION['username'])) {

        $username = $_SESSION['username'];

    } else {
		
		$username = 'guest';
		
	}

    $commentbox = $_POST['commentbox'];
	
	$p_xml_2->addChild('boxU', $id);
    $p_xml_2->addChild('boxT', $commentbox);
 
    $p_xml_2->asXml('posts/' . basename($_SERVER['QUERY_STRING']) . '.xml');

    echo '<b>done</b><br />';
	
	print_r($_POST);
            
}

if(isset($_POST['edit'])) {
	$p_xml_2->post = $_POST['post'];
    $p_xml_2->asXML(basename($_SERVER['QUERY_STRING']) . '.xml');
    echo '<b>Done</b><br />';
	print_r($_POST);
    die;
}

include('bbcode.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>GR8BRIK community forums</title>

    <link rel="stylesheet" href="../w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <meta charset="UTF-8">
    <meta name="author" content="sussteve226">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body class="w3-light-blue w3-container">

<?php include('../navbar.php') ?>

        <?php echo "<h1>" . urldecode($p_xml_2->title) . "</h1>" ?>
		
		
		<script>
		
		function edit() {
			
		    // Assuming you have a table with an ID "myTable"
			const table = document.getElementById("table");

			// Assuming you want to convert the first cell in the first row
			const targetCell = table.rows[0].cells[0];

			// Create a textarea element
			const textarea = document.createElement("textarea");

			// Copy cell content to the textarea
			textarea.value = targetCell.value;
			textarea.name = 'post';

			// Replace cell content with the textarea
			targetCell.innerHTML = ""; // Clear existing content
			targetCell.appendChild(textarea);
			
			document.getElementById('submit').style.display = 'block';
			
			document.getElementById('editBtn').style.display = 'none';
			
			document.getElementById('cancel').style.display = 'block';
			
		}
		
		function editPost() {
			
			document.getElementById('post').style.display = 'block';
			
			document.getElementById('editBtn').style.display = 'none';
			
			document.getElementById('cancel').style.display = 'block';
			
			document.getElementById('postBtn').style.display = 'block';

			
		}
		
		function cancel() {
			
			document.getElementById('post').style.display = 'none';
			
			document.getElementById('editBtn').style.display = 'block';
			
			document.getElementById('cancel').style.display = 'none';
			
			document.getElementById('postBtn').style.display = 'none';

			
		}
		
		</script>


        <?php
		
		// Create connection
		$conn = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);
			
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		
		// Query to get username by user ID
		$uname = $p_xml_2->uname;

		$sql = "SELECT username FROM users WHERE id = $uname";
		$result = $conn->query($sql);
			
		if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			$uname2 = $row['username'];
			echo '<table class="w3-table-all w3-card-24"><td><h3><img src="../acc/users/pfps/' . $uname . '..jpg" style="width:50px;height:50px;border-radius:50px;">by <a href="../profile.php?user=' . $uname . '">' . $uname2 . '</a></h3><h5>on ' . $p_xml->date . '</h5></td></table>';
			echo '<table class="w3-table-all w3-card-24" id="table" name="table"><td value="' . $p_xml->post . '"><h5>' . $p_xml->post . '</h5></td></table>';
		}
			
			if (trim($_SESSION['username']) === trim($uname2)) {
				
				echo "<form method='post' action=''><textarea id='post' name='post' rows='4' cols='50' style='display:none'>" . $p_xml->post . "</textarea>";
				echo '<input type="submit" class="w3-btn w3-round w3-hover-opacity" id="postBtn" name="edit" value="post" style="display:none;"></form>';
				echo '<button class="w3-btn w3-round w3-hover-opacity" id="editBtn" onclick="editPost();">edit</button><br />';
				echo '<button class="w3-btn w3-round w3-hover-opacity" id="cancel" onclick="cancel();" style="display:none;">cancel</button><br />';
				
			} else {
				
				// The usernames do not match
				echo "<br /><b>you are logged in as:" . $_SESSION['username'] . '</b>';
				
			}
			
			echo "<br /><form method='post' action=''><textarea class='w3-card-24' name='commentbox' placeholder='Add a comment...' rows='4' cols='50'></textarea><br /><input type='submit' value='post' name='comment' class='w3-btn w3-blue w3-hover-opacity' /><altcha-widget challengeurl='https://eu.altcha.org/api/v1/challenge?apiKey=ckey_01d9f4ad018c16287ca6f3938a0f' style='background-color:white!important;'></altcha-widget></form>";
			echo "<hr /><h3>comments</h3><br />";
			
			// Create connection
			$conn = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);
			
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}
			
			for ($i = 0; $i < count($p_xml_2->boxU); $i++) {
				// Query to get username by user ID
				$userId = (int)$p_xml_2->boxU[$i];
				$commentText = (string)$p_xml_2->boxT[$i];

				// $userId = $p_xml_2->boxU; Your user ID
				$sql = "SELECT username, handle FROM users WHERE id = $userId";
				$result = $conn->query($sql);
			
				if ($result->num_rows > 0) {
					$row = $result->fetch_assoc();
					$username = $row['username'];
					$handle = $row['handle'];
					echo '<table class="w3-table-all w3-card-24 w3-round">';
					echo '<tr><td><h4 style="display: flex; align-items: center;"><a href="../profile.php?user=' . $userId . '"><img src="../acc/users/pfps/' . $userId . '..jpg" style="width:50px;height:50px;border-radius:50px;">' . $username . ' (@' . $handle . ')</a></h4></td></tr>';
					echo '<tr><td><h5>' . $commentText . '</h5></td></tr>';
					echo '</table><br />';
				}
			}

			$conn->close();

            echo '</div><br /><br />';

            include('../linkbar.php');

        ?>

</body>
</html>