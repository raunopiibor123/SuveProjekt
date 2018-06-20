<?php

/**
 * This file creates the index page when user is not logged in
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
require_once "functions.php";
if (isset($_SESSION["user_id"])) {
    header("Location: main.php");
    exit();
}

require_once "classes/Useractions.class.php";
$Register = new UserActions();

if (isset($_POST["signupButton"])) {
    if (isset($_POST["signupEmail"]) && isset($_POST["signupOrganization"]) && isset($_POST["signupPassword"])) {
        $registerEmail = test_input($_POST['signupEmail']);
        $registerPassword = test_input($_POST['signupPassword']);
        $registerOrganization = test_input($_POST['signupOrganization']);
        $Register->registerUser($registerEmail, $registerPassword, $registerOrganization);
        $Register->login($registerEmail, $registerPassword);
    }
}
if (isset($_POST["signinButton"])) {
    if (isset($_POST["loginEmail"]) && isset($_POST["loginPassword"])) {
        $loginEmail = test_input($_POST['loginEmail']);
        $loginPassword = test_input($_POST['loginPassword']);
        $Register->login($loginEmail, $loginPassword);
        header("Location: main.php");
        exit();
    } else {
        echo 'Invalid login';
    }
}

require_once "elements.php";
createHeader("Main Page");
createNavbar();
createRegisterModal();

?>
<style>
    html, body {
      position: relative;
      height: 100%;
    }

    body {
      background: #eee;
      font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
      font-size: 14px;
      color:#000;
      margin: 0;
      padding: 0;
      background-image: url("img/background.jpg");
    }
    .swiper-container {
      width: 100%;
      height: 100%;
      
    }
    .swiper-slide {

      font-size: 50px;
      /* Center slide text vertically */
      display: -webkit-box;
      display: -ms-flexbox;
      display: -webkit-flex;
      display: flex;
      -webkit-box-pack: center;
      -ms-flex-pack: center;
      -webkit-justify-content: center;
      justify-content: center;
      -webkit-box-align: center;
      -ms-flex-align: center;
      -webkit-align-items: center;
      align-items: center;
    }

    .parallax-bg {
      position: absolute;
      left: 0;
      top: 0;
      width: 130%;
      height: 100%;
      -webkit-background-size: cover;
      background-size: cover;
      background-position: center;
    }

    .frontPageText1{
        text-align:center;
        color: whitesmoke;
        text-shadow: 2px 2px 14px black;
    }
    .frontPageText2{
        text-align:center;
        color: whitesmoke;
        text-shadow: 2px 2px 14px black;
    }
    .frontPageText3{
        text-align:center;
        color: whitesmoke;
        text-shadow: 2px 2px 14px black;
    }
  </style>
<div class="swiper-container">
<div class="parallax-bg" style="background-image:url(img/background.jpg)" data-swiper-parallax="-20%"></div>
    <div class="swiper-wrapper">
      <div class="swiper-slide"><div class="frontPageText1">Tere tulemast <br> meie grupitöö lehele</div></div>
      <div class="swiper-slide"><div class="frontPageText2">Liikmed: <br>Rasmus Kello<br> Hendrik Heinsar<br> Rauno Piibor<br> Elinor Roosalu<br> Krister Riska</div></div>
      <div class="swiper-slide"><div class="frontPageText3">Tarkvaraarenduse Praktika <br> Tallinna Ülikool <br> 2018</div></div>
    </div>
    <div class="swiper-scrollbar"></div>
  </div>
<?php
createFooter();
?>
<script>
    var swiper = new Swiper('.swiper-container', {
        speed: 600,
        parallax: true,
        scrollbar: {
          el: '.swiper-scrollbar',
          hide: true,
        },
      });

      
var columns = document.getElementsByClassName("frontPageText1");
TweenMax.staggerFrom(columns, 1, {
    opacity: 0,
    scale: 0,
    ease: Bounce.easeOut,
    delay: 0
}, 0.5);
</script>