<?php
require_once("classes/Useractions.class.php");
function createHeader($siteTitle){
echo'
<!DOCTYPE html>
<html lang="et-EE">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>'.$siteTitle.'</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/swiper.min.css">
        <link href="https://fonts.googleapis.com/css?family=Old+Standard+TT" rel="stylesheet"> 
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.20.2/TweenMax.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <script src="https://code.highcharts.com/modules/export-data.js"></script>
        <script src="js/script.js"></script>
    </head>
    <body>
';
}

function createFooter(){
echo'
    </body>
</html>
    ';
}

function createNavbar(){
    if (isset($_POST["signoutButton"])){
        session_destroy();
        header("Location: index.php");
        exit();
    }
    if (isset($_SESSION["user_id"])) {
    $info = new UserActions();
    echo'
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand navanim" href="#">SuveProjekt</a>
        </div>
        <ul class="nav navbar-nav">
            <li><a href="main.php">Avaleht</a></li>
            <li><a href="questions.php">Küsimustik</a></li>
            <li><a href="raportid.php">Raports</a></li>
        </ul>
        <p class="navbar-text" style="float: right">Sisse logitud : '; echo $info->getEmail($_SESSION["user_id"]); echo'<a href="#"></a></p>
        <form id="signout" class="navbar-form navbar-right" role="form" method="POST" action="">
        <button type="submit" class="btn btn-primary navanim" name="signoutButton">Log out</button>
        </form>
        </div>
    </nav>
        ';
        }else{
        echo'
        <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container-fluid">
          <div class="navbar-header">
            <a class="navbar-brand navanim" href="#">SuveProjekt</a>
          </div>
          <ul class="nav navbar-nav">
              <li><a href="index.php">Logi Sisse</a></li>
          </ul>
        <form id="signin" class="navbar-form navbar-right" role="form" method="POST" action="">
        <div class="input-group navanim">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
            <input id="loginEmail" type="email" class="form-control" name="loginEmail" value="" placeholder="Email Address" required>                                        
        </div>

        <div class="input-group navanim">
            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
            <input id="loginPassword" type="password" class="form-control" name="loginPassword" value="" placeholder="Password" required>                                        
        </div>

        <button type="submit" class="btn btn-primary navanim" name="signinButton">Login</button>
        <button type="button" class="btn btn-default navanim" data-toggle="modal" data-target="#registerModal">Registreeri</button>
    </form>
    </div>
    </nav> 
    ';
    }
}

function createRegisterModal(){
    $info = new UserActions();
    echo '
    <div id="registerModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Registreeri siin</h4> <p style="color:red" id="msg"></p>
      </div>
      <div class="modal-body">
            <form class="form-horizontal" role="form" action="" method="POST" enctype="multipart/form-data">

                <div class="form-group">
                        <label for="signupEmail" class="col-sm-3 control-label">Email</label>
                        <div class="col-sm-9">
                            <input type="email" id="signupEmail" name="signupEmail" class="form-control" required>
                        </div>
                </div>

                <div class="form-group">
                    <label for="signupOrganization" class="col-sm-3 control-label">Organisatsioon</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="signupOrganization" id="signupOrganization">';
                        $list = $info->getOrganizations();
                        foreach ($list as $row){
                            echo '<option value="'.$row["id"].'">'.$row["school_name"].'</option>';
                        }
                        echo'</select>
                    </div>
                </div> 

                <div class="form-group">
                    <label for="signupPassword" class="col-sm-3 control-label">Parool</label>
                    <div class="col-sm-9">
                        <input type="password" id="signupPassword" name="signupPassword" placeholder="Password" class="form-control" required>
                    </div>
                </div>

          </div>
      <div class="modal-footer">
        <button type="submit" name="signupButton" id="signupButton" class="btn btn-primary">Registreeri</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </form>
      </div>
       <!-- /form -->
    </div>

  </div>
</div>
    ';
}

function createNewRaportModal(){
    $info = new UserActions();
    echo '
    <div id="newRaportModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">New</h4> <p style="color:red" id="msg"></p>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form" action="" method="POST" enctype="multipart/form-data">';
                    $months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                    foreach($months as $value) {
                        echo '
                        <div class="form-group">
                            <label for="'.$value.'" class="col-sm-3 control-label">'.$value.'</label>
                            <div class="col-sm-9">
                            <input type="text" id="'.$value.'" name="'.$value.'" class="form-control" required>
                            </div>
                        </div>';
                    }
           echo'</div>
                <div class="modal-footer">
                    <button type="submit" name="createRaportButton" id="createRaportButton" class="btn btn-primary">Create</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </form>
                </div>
                <!-- /form -->
            </div>

  </div>
</div>
    ';
}
?>