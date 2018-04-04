<?php

	require("../../config.php");

	if(!isset($_SESSION["userId"])){
		header("Location: login.php");
		exit();
	}

	if(isset($_GET["logout"])){
		session_destroy();
		header("Location: login.php");
		exit();
	}
?>

<!DOCTYPE html>
<html lang="et">
<head>
</head>
<body>


<form>

</form>
<p><a href="?logout=1">Logi välja!</a></p>
</body>

</html>