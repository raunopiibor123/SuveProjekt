<?php

/**
 * This file creates the main page when user is logged in
 *
 * PHP version 5.6.30-0+deb8u1
 *
 * @category Tarkvaraarenduse_Praktika
 * @package  Roheline
 * @author   Rasmus Kello <rasmus.kello@tlu.ee>
 * @author   Rauno Piibor
 * @author   Hendrik Heinsar
 * @author   Elinor Roosalu
 * @author   Krister Riska
 * @license  [https://opensource.org/licenses/MIT] [MIT]
 * @link     ...
 */

session_start();
require_once "classes/Useractions.class.php";
$info = new UserActions();
require "config.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit();
}

if (isset($_GET["logout"])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

require_once "elements.php";
createHeader("Main Page");
createNavbar();
?>
<!DOCTYPE html>
<html>
<head>
	<title>eksam</title>
</head>
<body>
	<h3>Tere, <?php echo $info->getEmail($_SESSION["user_id"]); ?>, koolist <?php echo $info->getSchoolName($info->getSchool($_SESSION["user_id"])); ?></h3>
</body>
</html>
