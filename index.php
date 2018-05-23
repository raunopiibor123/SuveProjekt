<?php
session_start();
require_once("functions.php");
if(isset($_SESSION["user_id"])){
    header("Location: main.php");
    exit();
}

require_once("classes/Useractions.class.php");
$Register = new UserActions();

if (isset($_POST["signupButton"])) {
    if(isset($_POST["signupEmail"]) && isset ($_POST["signupOrganization"]) && isset ($_POST["signupPassword"])){
        $registerEmail = test_input($_POST['signupEmail']);
        $registerPassword = test_input($_POST['signupPassword']);
        $registerOrganization = test_input($_POST['signupOrganization']);
        $Register->registerUser($registerEmail, $registerPassword, $registerOrganization);
        $Register->login($registerEmail, $registerPassword);
    }
}
if (isset($_POST["signinButton"])) {
    if (isset ($_POST["loginEmail"]) && isset ($_POST["loginPassword"])) {
        $loginEmail = test_input($_POST['loginEmail']);
        $loginPassword = test_input($_POST['loginPassword']);
        $Register->login($loginEmail, $loginPassword);
        header("Location: main.php");
        exit();
        } else {
            echo 'Invalid login';
        }
}

require_once("elements.php");
createHeader("Main Page");
createNavbar();
createRegisterModal();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Eksami jaoks</title>
</head>
<body>
    <h3>Tere</h3>
</body>
</html>