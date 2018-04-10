<?php
	require("functions.php");

	$loginEmail = "";
	$notice = "";
	$loginEmailError ="";
	
	if(isset($_SESSION["userId"])){
		header("Location: main.php");
		exit();
	}
	
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
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<meta charset="utf-8">
	<title>Sisselogimine või uue kasutaja loomine</title>
    <div class="container">
    <h1 class="welcome text-center">Welcome to <br> GreenPower</h1>
        <div class="card card-container">
        <h2 class='login_title text-center'>Login</h2>
        <br>
            <form class="form-signin">
                <span id="reauth-email" class="reauth-email"></span>
                <p class="input_title">Email</p>
                <input type="email" name="loginEmail" class="login_box" placeholder="email" value="<?php echo $loginEmail; ?>" required autofocus>
                <p class="input_title">Password</p>
                <input type="password" id="inputPassword" class="login_box" placeholder="******" required>
                <div id="remember" class="checkbox">
                </div>
                <button class="btn btn-lg btn-primary" type="submit">Login</button><?php echo $notice; ?></span>
                <p><a href="registrate.php">Loo uus kasutaja</a></p>
            </form>
        </div>
    </div>
