<?php

	require_once $_SERVER['DOCUMENT_ROOT'] . '/gr8brik/gr8brik-assets/acc/classes/constants.php';

		// Create connection
		$conn = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);

		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		
		$session = $_SESSION['username'];
		$sql = "SELECT alert, username, id, email, password, admin FROM users WHERE username = ?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("s", $session);
		$stmt->execute();
		$stmt->bind_result($alert, $user, $id, $email, $pwd, $admin);
		$stmt->fetch();
		
		if($user != $session){
			header('Location: error.php?error=500');
		}

?>