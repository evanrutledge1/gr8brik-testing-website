<?php
session_start();

$ad = '<!-- BEGIN BANNER --><br><a href="http://www.gr8brik.rf.gd"><img src="http://' . $_SERVER['HTTP_HOST'] . '/gr8brik/gr8brik-assets/img/addesign.gif" width="468"height="60" border="0" alt="Gr8brik is THE BEST free IN BROWSER lego building software! Visit us at www.gr8brik.rf.gd"></a><br><!-- END BANNER -->';

$error = $_GET['error'];

$user = $_SESSION['username'];

if($_POST){

        die('<b>this page dosent support server-side posts</b>');
            
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $error . ' error'?></title>
    <link rel="stylesheet" href="/gr8brik/gr8brik-assets/w3.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <meta charset="UTF-8">
    <meta name="description" content="Gr8brik is a block building browser game. No download required">
    <meta name="keywords" content="legos, online block builder, gr8brik, online lego modeler, barbies-legos8885 balteam, lego digital designer, churts, anti-coppa, anti-kosa, churtsontime, sussteve226, manofmenx">
    <meta name="author" content="sussteve226">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
</head>
<body class="w3-light-blue w3-container">

		<script>
			function copy() {
				// Get the text field
				var copyText = $("#img");

				// Select the text field
				copyText.select();
				copyText[0].setSelectionRange(0, 99999); // For mobile devices

				// Copy the text inside the text field
				navigator.clipboard.writeText(copyText.val());

				// Alert the copied text
				$("<br /><span class='w3-tag w3-grey'><b>Copied!</b></span>").appendTo("center").hide().fadeIn(3000).fadeOut(3000);
			}
		</script>


        <center>
			<?php
				if($error === '404') {
					echo "<h1>Page not found!</h1>";
					echo "<b>This page wasn't found here. Try looking somewhere else.</b>";
				}
				if($error === '403') {
					echo "<h1>You can't access this</h1>";
					echo "<b>This page needs you to login, or isn't for you.</b>";
				}
				if($error === '500') {
					echo "<h1>You're disconnected</h1>";
					echo "<b>Your offline, or someone pulled the wrong plug on our end.</b>";
				} 
				if ($error !== '403' && $error !== '404' && $error !== '500' || $error === '') {
					echo "<h1>Oops!</h1>";
					echo "<b>An unknown error has happened. Try closing and re-opening GR8BRIK related tabs/windows.</b>";
				}
			?>
			<br /><b>Support us by adding this to your website:</b>
			<?php echo $ad; ?>
			<b>Code:</b><br />
			<div class="w3-card-24 w3-white">
				<textarea id="img" readonly style="width:100%;border:none;"><?php echo htmlspecialchars($ad); ?></textarea>
			</div><br />
			<button onclick="copy();" class="w3-btn w3-blue w3-hover-opacity">copy</button>
			
		</center>

</body>
</html>