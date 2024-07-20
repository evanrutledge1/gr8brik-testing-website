<?php

session_start();

if(!isset($_SESSION['username'])){

    header('Location: login.php');

}

require_once 'classes/constants.php';

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

			// Fetch the current password from the database
			$conn = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);
			$stmt = $conn->prepare("SELECT alert FROM users WHERE username = ?");
			$username = $_SESSION['username'];
			$stmt->bind_param("s", $username);
			$stmt->execute();
			$stmt->bind_result($db_alert);
			$stmt->fetch();
			$stmt->close();
			$alertnum = '0';
			$stmt_2 = $conn->prepare("update users SET alert = ? WHERE username = ?");
            $stmt_2->bind_param("ss", $alertnum, $username);
            if ($stmt_2->execute()) {
                header("Location: index.php");
            } else {
                echo "An error has occurred";
            }
            $stmt->close();
            die;

?>