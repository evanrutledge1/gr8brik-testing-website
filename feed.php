<?php
session_start();

if(!isset($_SESSION['username'])){

    header('Location: acc/login.php');

    die;

}

require_once $_SERVER['DOCUMENT_ROOT'] . '/gr8brik/gr8brik-assets/acc/classes/constants.php';

// Create connection
		$conn = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);
	
	// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		$session = $_SESSION['username'];
		$sql = "SELECT id FROM users WHERE username = ?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("s", $session);
		$stmt->execute();
		$stmt->bind_result($id);
		$stmt->fetch();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Your feed - GR8BRIK</title>
    <link rel="stylesheet" href="w3.css">
    <link rel="stylesheet" href="theme.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <meta charset="UTF-8">
    <meta name="description" content="Gr8brik is a block building browser game. No download required">
    <meta name="keywords" content="legos, online block builder, gr8brik, online lego modeler, barbies-legos8885 balteam, lego digital designer, churts, anti-coppa, anti-kosa, churtsontime, sussteve226, manofmenx">
    <meta name="author" content="sussteve226">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class="w3-light-blue w3-container">

<?php 

    include('navbar.php');
    
?>
        <div class="w3-container">
                <p>Want to build your own model? <a href="modeler.php" class="w3-btn w3-blue w3-hover-opacity">modeler</a></p>
        </div>

        <div class="w3-black w3-card-8 w3-center">
            <h1>Welcome to your feed, <?php echo $_SESSION['username']; ?><a href="acc/index.php#username"><i class="fa fa-pencil" aria-hidden="true"></i></a></h1><br />
            <img src=<?php echo 'acc/users/pfps/' . $id . '..jpg' ?> style='width: 250px; height: 250px; border-radius: 50%;cursor:zoom-in' class="w3-hover-shadow" onclick="document.getElementById('im').style.display='block'" /><br />
            <a href="acc/index.php" class="w3-btn w3-large w3-white w3-hover-blue"><b><i class="fa fa-wrench" aria-hidden="true"></i>manage</b>
</a>
            <a href=profile.php?user=<?php echo $id ?> class="w3-btn w3-large w3-white w3-hover-blue"><b><li class="fa fa-user" aria-hidden="true"></li>profile</b></a>
        </div>
		
		<div id="im" class="w3-modal w3-center" onclick="this.style.display='none'">

            <span class="w3-closebtn w3-red w3-hover-white w3-padding w3-display-topright">&#10006;</span>

            <img class="w3-modal-content" src="<?php echo 'acc/users/pfps/' . $id . '..jpg' ?>" style="width:75%;" loading="lazy">

        </div>

        <h3 class="w3-center">Here are some things you might be interested in</h3>

        <table class="w3-table-all" style="color:black;">
        
            <?php
                $i = 0;
                foreach (glob("cre/*json") as $_FF) {
                    echo "<div class='w3-display-container w3-left'>";
                    echo "<a href='creation.php?" . $_FF . "'><img src='img/blured_model.jpg' width='320' height='240' class='w3-hover-opacity w3-round w3-border'></a>";
                    echo "<b class='w3-display-middle'>" . $_FF . "</b></div>";
                    if (++$i == 4) break;
                };

            ?>
			
        </table><div class="w3-center"><hr /><h3>Like these?</h3><a href='list.php' class='w3-btn w3-blue w3-hover-opacity'>more</a><br /><br /><br /></div>


    <?php include('linkbar.php'); ?>


</body>
</html>