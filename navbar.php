<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/gr8brik/gr8brik-assets/acc/classes/user.php';

?>

<link rel="stylesheet" href="/gr8brik/gr8brik-assets/w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<nav class="w3-sidenav w3-black w3-hide-small w3-large w3-card-24 w3-top" style="width:20%">
	<a href="/index.php"><img src="/gr8brik/gr8brik-assets/img/logo.jpg" style="width:30px;height:30px;border-radius:15px;"><b>gr8brik</b></a>
	<a href="/modeler.php">modeler</a>
	<a href="/list.php">creations</a>
	<a href="/com/index.php">community</a>
	<form method="get" action="../list.php?">
        <input class="w3-input w3-border" type="text" placeholder="search" name="q" style="width:100%">
        <input type="submit" value="&#128270;">
    </form><hr />
	<?php
		
		if(!isset($_SESSION['username'])){
			echo "<a href='/acc/login.php'>login</a>";
            echo "<a href='/acc/register.php'>register</a>";
        } else {
            echo "<a href='/acc/index.php' title='click to manage settings of " . $session . "'><i class='fa fa-user-o' aria-hidden='true'></i><b>" . $session . "</b></a>";
			echo "<a href='/acc/new.php' title='click to view " . $alert . " of your notifications'><i class='fa fa-envelope-o' aria-hidden='true'></i><span class='w3-badge w3-red'>" . $alert . " in-box</span><span class='w3-tag w3-blue'>NEW</span></a>";
			echo "<a href='/acc/logout.php' title='click to logoff " . $session . "'><i class='fa fa-sign-out' aria-hidden='true'></i>logout</a>";
        }
		
    ?>
	
	<button id="toggle" xclass="w3-btn w3-white w3-hover-dark-grey" onclick="toggleDarkMode()" title="Dark mode"><i class="fa fa-moon-o" aria-hidden="true"></i></button>
	<button id="toggle" xclass="w3-btn w3-dark-grey w3-hover-white" onclick="toggleLightMode()" title="Light mode"><i class="fa fa-lightbulb-o" aria-hidden="true"></i></button>
</nav>

<div class="w3-main w3-animate-top" style="margin-left:25%;">

<style>
	
	#loading {
		position: fixed;
		width: 100%;
		height: 100%;
		top: 0;
		left: 0;
		background: rgba(255, 255, 255, 0.8);
		display: flex;
		justify-content: center;
		align-items: center;
		z-index: 9999;
		border: 1px;
		border-radius: 15px;
	}
	
	body {
		transition: all 1s ease-in-out;
	}
	
	// #toggle {
		// transition: all 0.5s ease-in-out;
		// border-radius: 5%;
		// font-size: 25px;
		
	// }
	
	// #toggle:hover {
		// transform: translateY(-10px);
		// border-radius: 15%; /* Border radius on hover */
		// border: 1px solid;
		// box-shadow: 5px 5px 5px 0px skyblue;
	// }
	input[type=submit], #toggle {
		transition: all 0.5s ease-in-out;
		border-radius: 1px;
		border: 1px solid;
		font-size: 35px;
		box-shadow: 5px 5px 5px 0px black;
		background-image: linear-gradient(#fdfdff, #d3d3d3);
		text-transform: uppercase;
	}
	input[type=submit]:hover, #toggle:hover {
		transform: translateY(-10px);
		background-image: linear-gradient(#fdfdff, #fdfdff);
		cursor: pointer;
		border-radius: 25px;
	}
	
	</style>
	
	<div id="cookie-message">
		<p class="w3-light-grey w3-border w3-padding w3-round">
			GR8BRIK uses cookies to ensure we give you the best experience on our website.
			<button onclick="javascript:window.location.reload();" class="w3-btn w3-blue w3-border w3-hover-opacity" target="_blank">ACCEPT</button>
			<a href="/privacy" class="w3-btn w3-white w3-border" target="_blank">LEARN MORE</a>
		</p>
	</div>
	
	<!--[if lt IE 9]>
        <br /><p class="w3-red w3-border w3-padding w3-round"><img class="w3-mobile" src="img/warning.jpg" width="25px" height="25px" alt="Warning"> You are using an <b>outdated</b> browser. Please <a href="http://www.browsehappy.com">upgrade your browser</a> below, or <a href="http://www.google.com/chromeframe">activate Google Chrome Frame</a> to improve your experience.</p>
	<![endif]-->
	<script>
		function toggleDarkMode() {
			var element = document.body;
			element.classList.add("w3-dark-grey");
			localStorage.setItem("theme", "dark");
		}

		function toggleLightMode() {
			var element = document.body;
			element.classList.add("w3-light-blue");
			localStorage.setItem("theme", "light");
		}

		window.onload = function() {
			var theme = localStorage.getItem("theme");
			var element = document.body;

			if (theme === "dark") {
				element.classList.add("w3-dark-grey");
			} else if (theme === "light") {
				element.classList.add("w3-light-blue");
			}
		}

    </script>
	<script src="/gr8brik/gr8brik-assets/cookie-message.js"></script>