<?php
    require("functions.php");
    
    $notice="";
    $signupEmail = "";
    $signupEmailError = "";
    $signupPassword = "";
	$signupPasswordError = "";
	$confirmPassword = "";
	$confirmPasswordError = "";
	$matchingPasswordError="";
 

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
	
	if($_POST["signupPassword"]!=$_POST["confirmPassword"]){
			$matchingPasswordError = "Paroolid ei klapi";
		} else {
			if (empty(($signupEmailError) and empty($signupPasswordError) and empty($confirmPasswordError) and empty($matchingPasswordError))){
			$signupPassword = hash("sha512", $_POST["signupPassword"]);		
			signUp($signupEmail, $signupPassword);
			
		}
	}	
	
}

?>

<!DOCTYPE html>
<html lang="et">
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
    <meta charset="utf-8">
	<title>Uue kasutaja loomine</title>
</head>
<body>
	<h1 class='login_title text-center'>Loo kasutaja</h1>
    <div class="container">
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
	<label>Kasutajanimi (E-post)</label>
	<br>
			<div class="card card-container">
			<form class="form-signin">
				
				<input name="signupEmail" type="email" class="login_box" value="<?php echo $signupEmail; ?>">
				<span><?php echo $signupEmailError; ?></span>
				<label>Parool</label>
				<input name="signupPassword" placeholder="********" class="login_box" type="password">
				<span><?php echo $signupPasswordError; ?></span>
				<label>Kinnita salasõna</label>
				<input name="confirmPassword" placeholder="********" class="login_box" type="password">
				<span><?php echo $confirmPasswordError; ?></span>
				<span><?php echo $matchingPasswordError; ?></span>
				<label>Vali kool</label>
				<input name="signupButton" class="btn btn-lg btn-primary" type="submit" class="login_box" value="Loo kasutaja">
				<p><a href="login.php">Logi sisse</a></p>   
			</form>
		</div>
	</div>
	</form></div>
</body>
</html>


