<?php
	session_start();

	if(!isset($_SESSION["user_id"])){
		header("Location: index.php");
		exit();
	}

	if(isset($_GET["logout"])){
		session_destroy();
		header("Location: login.php");
		exit();
	}

	require_once("elements.php");
	createHeader("Main Page");
	createNavbar();
?>

