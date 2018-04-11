<?php

	require("../../config.php");

	/*if(!isset($_SESSION["userId"])){
		header("Location: login.php");
		exit();
	}*/

	if(isset($_GET["logout"])){
		session_destroy();
		header("Location: login.php");
		exit();
	}
?>

<!DOCTYPE html>
<html lang="et">
<head>
	<title>Avaleht</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>


<form>

</form>
<div class="btn-group-vertical">
	<button type="button" class="btn btn-outline-success"><a href="?logout=1">Logi välja</a></button>
	<button type="button" class="btn btn-outline-success"><a href="main.php">Statistika</a></button>
	<button type="button" class="btn btn-outline-success"><a href="main.php">Tips</a></button>
</div>	
</body>

</html>