<?php
    require("functions.php");
    
    $notice="";
    $signupEmail = "";
    $signupEmailError = "";
    $signupPassword = "";
	$signupPasswordError = "";
	$confirmPassword = "";
	$confirmPasswordError = "";
 

	if(isset($_POST["signupButton"])){
	if (isset ($_POST["signupEmail"])){
		if (empty ($_POST["signupEmail"])){
			$signupEmailError ="NB! Väli on kohustuslik!";
		} else {
			$signupEmail = test_input($_POST["signupEmail"]);
						
			$signupEmail = filter_var($signupEmail, FILTER_SANITIZE_EMAIL);
			$signupEmail = filter_var($signupEmail, FILTER_VALIDATE_EMAIL);
		}
	}
	
	if (isset ($_POST["signupPassword"])){
		if (empty ($_POST["signupPassword"])){
			$signupPasswordError = "NB! Väli on kohustuslik!";
		} else {
			if (strlen($_POST["signupPassword"]) < 8){
				$signupPasswordError = "NB! Liiga lühike salasõna, vaja vähemalt 8 tähemärki!";
			}
		}
	}

	if (isset ($_POST["confirmPassword"])){
		if (empty ($_POST["confirmPassword"])){
			$confirmPasswordError = "NB! Väli on kohustuslik!";
		}
	}
	
	if (empty(($signupEmailError) and empty($signupPasswordError))){
		$signupPassword = hash("sha512", $_POST["signupPassword"]);		
		signUp($signupEmail, $signupPassword);
		
	}
	
}

?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="utf-8">
	<title>Uue kasutaja loomine</title>
</head>
<body>
    <h1>Roheline</h1>

    <h2>Loo kasutaja</h2>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
		<br>
		<label>Kasutajanimi (E-post)</label>
		<input name="signupEmail" type="email" value="<?php echo $signupEmail; ?>">
		<span><?php echo $signupEmailError; ?></span>
		<br><br>
		<input name="signupPassword" placeholder="Salasõna" type="password">
		<span><?php echo $signupPasswordError; ?></span>
		<br><br>
		<input name="confirmPassword" placeholder="Kinnita salasõna" type="password">
		<span><?php echo $confirmPasswordError; ?></span>
		<br><br>
        <input name="signupButton" type="submit" value="Loo kasutaja">
        <p><a href="login.php">Logi sisse</a></p>
        
	</form>



