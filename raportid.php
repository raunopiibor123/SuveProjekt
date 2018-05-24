<?php
	session_start();
	require("config.php");

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
	createHeader("Raport");
    createNavbar();
    createNewRaportModal();

    $notice = "";
    $target_dir = "pics/";
    $target_file = "";
    $uploadOk = 1;
    $database = "if17_heinhend";

    function saveIdea($target_file){
		$notice = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO raportiteTabel (raportFile) VALUES (?)");
		echo $mysqli->error;
		$stmt->bind_param("s", $target_file);
		console.log($stmt->error);
		$stmt->close();
		$mysqli->close();
		return $notice;
	}


    if (isset($_POST["submit"])) {
		$timeStamp = microtime(1) *10000;
		$target_file = $target_dir . "hmv_" .$timeStamp .".csv";
		//$target_file_2 = $target_dir_2 . "hmv_" .$timeStamp ."." ."jpg";

        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
            }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
        saveIdea($target_file);
    }
    
?>
<head>
<link type="text/css" rel="stylesheet" href="css/main.css"/>
</head>
<div class="container">
    <table class="data-table col-md-6 col-md-offset-3">
        <caption class="title" style="color:#000000; text-align:center; font-weight:bold; font-size:32px;"> RAPORTID </caption>
    <thead>
	    <tr>
		    <th>Link</th>
			<th>Name</th>
			<th>Description</th>				
	    </tr>
	</thead>
    <tbody>
        <tr>
            <td>
                <a href="raport.php?rId=1">Raport 1</a><br>
            </td>
            <td>
                Nimi 1
            </td>
            <td>
                Desc 1
            </td>
        </tr>
        <tr>
            <td>
                <a href="raport.php?rId=2">Raport 2</a><br>
            </td>
            <td>
                Nimi 2
            </td>
            <td>
                Desc 2
            </td>
        </tr>
        <tr>
            <td>
                <a href="raport.php?rId=3">Raport 3</a><br>
            </td>
            <td>
                Nimi 3
            </td>
            <td>
                Desc 3
            </td>
        </tr>
        <tr>
            <td>
                <a href="raport.php?rId=4">Raport 4</a><br>
            </td>
            <td>
                Nimi 4
            </td>
            <td>
                Desc 4
            </td>
        </tr>
    </tbody>
</table>
    <button type="button" class="btn btn-primary btn-md" style="margin-top:4px" data-toggle="modal" data-target="#newRaportModal1">Create New</button>

    <div id="newRaportModal1" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">New</h4> <p style="color:red" id="msg"></p>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form" action="" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-3 control-label">Name:</label>
                            <div class="col-sm-8">
                                <input type="text" id="raportName" name="raportName" class="form-control" required>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 5px;">
                            <label class="col-sm-3 control-label">Description:</label>
                                <div class="col-sm-8">
                                    <input type="text" id="raportDesc" name="raportDesc" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6" >
                            <label style="margin-top: 10px; padding: 5px;">Upload CSV file</label>
                            <input type="file" name="fileToUpload" id="fileToUpload" required><span stlye="margin: 4px; padding: 4px;"></span>
                        </div>
                        <!--<ul class="nav nav-tabs">
                            <div class="col-sm-6">
                                <input type="radio" name="inputType" id="CSVInput" class="form-control" value="csv"><label>CSV file</label>
                            </div>
                            <div class="col-sm-6">
                                <input type="radio" name="inputType" id="manualInput" class="form-control" value="manual"><label>Manual input</label>
                            </div>
                        </ul>-->
                    <div class="modal-footer">
                        <button type="submit" name="createRaportButton" id="createRaportButton" class="btn btn-primary">Create</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </form>
            </div>
            <!-- /form -->
        </div>
    </div>
</div>
</div>


<script>
</script>
</body>