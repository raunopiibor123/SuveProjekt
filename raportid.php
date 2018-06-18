<?php

/**
 * This file creates the view of all raports for current user
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
createHeader("Raport");
createNavbar();
createNewRaportModal();

$notice = "";
$target_dir = "csv/";
$fileToUpload = "";
$uploadOk = 1;
$database = "if17_roheline";
$raportName = "";
$raportDesc = "";
$userid = $_SESSION["user_id"];

function saveFile($userid, $fileToUpload, $raportName, $raportDesc)
{
    $notice = "";
    $mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
    $stmt = $mysqli->prepare("INSERT INTO csv (userid, filename, title, description) VALUES (?, ?, ?, ?)");
    echo $mysqli->error;
    $stmt->bind_param("isss", $userid, $fileToUpload, $raportName, $raportDesc);
    if ($stmt->execute()) {
        $notice = "Kuulutus on salvestatud";
    } else {
        $notice = "Salvestamisel tekkis tõrge: " . $stmt->error;
    }
    $stmt->close();
    $mysqli->close();
    return $notice;
}

if (isset($_POST["createRaportButton"])) {
    $timeStamp = microtime(1) * 10000;
    $fileToUpload = $target_dir . "hmv_" . $timeStamp . ".csv";
    $raportName = $_POST["raportName"];
    $raportDesc = $_POST["raportDesc"];
    //$target_file_2 = $target_dir_2 . "hmv_" .$timeStamp ."." ."jpg";

    if (file_exists($fileToUpload)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $fileToUpload)) {
            echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
    saveFile($userid, $fileToUpload, $raportName, $raportDesc);

}

// ANDMEBAASIST LUGEMINE
$conn = new mysqli($serverHost, $serverUsername, $serverPassword, $database);
$sql = "SELECT filename, title, description FROM csv WHERE userid='$userid'";
//$conn->bind_param("i", $_SESSION['userId']);
$query = mysqli_query($conn, $sql);
$conn->close();
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
        <?php

while ($row = mysqli_fetch_array($query)) {
    echo '' . '<tr>
					<td><a href="raport.php?rId=' . $row['filename'] . '"> Raport </a></td>
					<td>' . $row['title'] . '</td>
					<td>' . $row['description'] . '</td>
				</tr>';
}?>
        <!--
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
        -->
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