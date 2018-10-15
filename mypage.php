<?php

session_start();

if(!isset($_SESSION["session_username"])):
header("location: index.php");
else:
?>
	
<?php include("includes/header.php"); ?>
<div id="profile">
<h2>Добро пожаловать, <span><?php echo $_SESSION['session_username'];?>! </span></h2>
  <p><a href="exit.php">Выйти</a> из системы</p>
</div>
	
<?php endif; ?>