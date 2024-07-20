<?php

require 'Mysql.php';

class Membership {
	
	function validate_user($un, $pwd) {
		$mysql = New Mysql();
		$ensure_credentials = $mysql->verify_Username_and_Pass($un, md5($pwd));
		
		if($ensure_credentials) {
			$_SESSION['status'] = 'authorized';
			header("location: index.php");
		} else return "Please enter a correct username and password";
		
	}
	
	function log_User_Out() {
		if(isset($_SESSION['status'])) {
			unset($_SESSION['status']);
			
			if(isset($_COOKIE['session_name()'])) setcookie(session_name(), '', time() - 1000);
			session_destroy();
		}
	}
	
	function confirm_Member() {
		session_start();
		if($_SESSION['status'] != 'authorized') header("location: login.php");
	}
	public function register_User($username, $password, $email) {
    $conn = new mysqli('localhost', 'root', '', 'membership');

		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}

		$username = $conn->real_escape_string($username);
		$password = md5($password);
		$email = $conn->real_escape_string($email);

		$sql = "INSERT INTO users (username, password, email) VALUES ('$username', '$password', '$email')";
	
		if ($conn->query($sql) === TRUE) {
			return "Registration successful!";
		} else {
			return "Error: " . $sql . "<br>" . $conn->error;
		}

		$conn->close();
	}

	
}
