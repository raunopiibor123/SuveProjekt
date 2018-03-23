<?php
	require("functions.php");

	
/*
	if(isset($_SESSION["userId"])){
		header("Location: main.php");
		exit();
	}
*/

	$loginEmail = "";
	$notice = "";

	
	$loginEmailError ="";
	
	if(isset($_POST["signinButton"])){
	
	if (isset ($_POST["loginEmail"])){
		if (empty ($_POST["loginEmail"])){
			$loginEmailError ="NB! Sisselogimiseks on vajalik kasutajatunnus (e-posti aadress)!";
		} else {
			$loginEmail = $_POST["loginEmail"];
		}
	}
	
	if(!empty($loginEmail) and !empty($_POST["loginPassword"])){
		$notice = signIn($loginEmail, $_POST["loginPassword"]);
	    }
}



	
?>
<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
	<title>Sisselogimine või uue kasutaja loomine</title>
</head>
<body>
	<h1>Roheline</h1>
	<h2>Logi sisse!</h2>
	
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
		<label>Kasutajanimi (E-post): </label>
		<input name="loginEmail" type="email" value="<?php echo $loginEmail; ?>"><span><?php echo $loginEmailError; ?></span>
		<br><br>
		<input name="loginPassword" placeholder="Salasõna" type="password"><span></span>
		<br><br>
		<input name="signinButton" type="submit" value="Logi sisse"><span><?php echo $notice; ?></span>
        <p><a href="registrate.php">Loo uus kasutaja</a></p>
	</form>
	
</body>
</html>