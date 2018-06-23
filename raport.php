<?php

/**
 * This file creates the raport view when user selects a raport from the list
 *
 * PHP version 5.6.30-0+deb8u1
 *
 * @category Tarkvaraarenduse_Praktika
 * @package  Roheline
 * @author   Rasmus Kello <rasmus.kello@tlu.ee>
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

require_once "classes/ParseCSV.class.php";

$rId = $_GET["rId"];
//$filename = substr($rId,4);
//$csvClass = new CSV("csv/tarbimisteatis.csv");
$csvClass = new CSV($rId);
$list = $csvClass->getMonthlyValues("2017");
$list2 = $csvClass->getYearlyValues();
$list3 = $csvClass->getWeeklyValues();
$list4 = $csvClass->getDailyValues();
$list5 = $csvClass->getMonthlyDailyValues("2017", "12");
//$list6 = $csvClass->getMonthlyMarketPrices("2017");

$target_dir = "csv/";
$database = "if17_roheline";
$userid = $_SESSION["user_id"];

// ANDMEBAASIST LUGEMINE
$conn = new mysqli($serverHost, $serverUsername, $serverPassword, $database, $serverPort);
$sql = "SELECT id, title, description FROM csv WHERE filename='$rId'";
//$conn->bind_param("i", $_SESSION['userId']);
$query = mysqli_query($conn, $sql);
$conn->close();
?>
<script>
function saveToDatabase(editableObj,column,id) {
    $.ajax({
        url: "updateNameDesc.php",
        type: "POST",
        data:'column='+column+'&editval='+editableObj.innerHTML+'&id='+id,
        success: function(data){
            
        }
   });
}
</script>
<div class="container">
<div class="jumbotron">
<?php
while ($row = mysqli_fetch_array($query)) {
    echo '
    <h1 contenteditable="true" class="editable" onBlur="saveToDatabase(this,\'title\',' . $row["id"] . ')">' . $row['title'] . '</h1>
    <p contenteditable="true" class="editable" onBlur="saveToDatabase(this,\'description\',' . $row["id"] . ')">' . $row['description'] . '</p>
    ';
}
?>
</div>
<h1>Aasta kohta</h1>
<div id="chartContainer1" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<hr>
<h1>Aasta lõikes</h1>
<div id="chartContainer" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<hr>
<h1>Kuu lõikes</h1>
<label for="datepicker2">Vali kuu(ükskõik milline päev)</label>
<input type="text" class="form-control" id="datepicker2" name="datepicker2">
<div id="chartContainer4" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<hr>
<h1>Nädala lõikes</h1>
<label for="datepicker1">Vali nädal(ükskõik milline päev)</label>
<input type="text" class="form-control" id="datepicker1" name="datepicker1">
<div id="chartContainer2" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<hr>
<h1>Päeva lõikes</h1>
<label for="datepicker">Vali kuupäev</label>
<input type="text" class="form-control" id="datepicker" name="datepicker">
<div id="chartContainer3" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
</div>

<script>
let file = '<?php echo $rId; ?>';
Highcharts.chart('chartContainer', {
    chart: {
        type: 'line'
    },
    title: {
        text: 'Elektrikasutus kuude lõikes'
    },
    xAxis: {
        categories: ['Jaanuar', 'Veebruar', 'Märts', 'Aprill', 'Mai', 'Juuni', 'Juuli', 'August', 'September', 'Oktoober', 'November', 'Detsember']
    },
    yAxis: {
        title: {
            text: 'KW'
        }
    },
    plotOptions: {
        line: {
            dataLabels: {
                enabled: false
            },
            enableMouseTracking: true
        }
    },
    series: [{
        name: 'Kokku',
        data: [
<?php foreach ($list as $value) {
    echo $value . ", ";
}
?>
              ]
    }]
});

Highcharts.chart('chartContainer1', {
    chart: {
        zoomType: 'x'
    },
    title: {
        text: 'Elektrikasutus aasta kohta'
    },
    xAxis: {
        categories: [
<?php
$valueArray = $list2[1];
foreach ($valueArray as $value) {
    echo $value . ", ";
}?>
                ]
    },
    yAxis: {
        title: {
            text: 'KW'
        }
    },
    plotOptions: {
        line: {
            dataLabels: {
                enabled: true
            },
            enableMouseTracking: false
        },
        area: {
                    fillColor: {
                        linearGradient: {
                            x1: 0,
                            y1: 0,
                            x2: 0,
                            y2: 1
                        },
                        stops: [
                            [0, Highcharts.getOptions().colors[0]],
                            [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                        ]
                    },
                    marker: {
                        radius: 2
                    },
                    lineWidth: 1,
                    states: {
                        hover: {
                            lineWidth: 1
                        }
                    },
                    threshold: null
                }
    },
    series: [{
        name: 'Kokku',
        type: 'column',
        data:   [
<?php
$valueArray = $list2[0];
foreach ($valueArray as $value) {
    echo $value . ", ";
}?>
                ]
    }]
});

let weekchart = Highcharts.chart('chartContainer2', {
    chart: {
        type: 'line'
    },

    title: {
        text: 'Elektrikasutus nädala lõikes'
    },
    xAxis: {
        categories: ['Esmaspäev', 'Teisipäev', 'Kolmapäev', 'Neljapäev', 'Reede', 'Laupäev', 'Pühapäev']
    },
    yAxis: {
        title: {
            text: 'KW'
        }
    },
    plotOptions: {
        line: {
            dataLabels: {
                enabled: false
            },
            enableMouseTracking: true
        }
    },
    series: [{
        name: 'Keskmine',
        data:   [
<?php
foreach ($list3 as $value) {
    echo $value . ", ";
}?>
                ]
    }, {
        name: 'Valitud nädal',
        data: []
    }]
});

let daychart = Highcharts.chart('chartContainer3', {
    chart: {
        type: 'line'
    },
    title: {
        text: 'Elektrikasutus päeva lõikes'
    },
    xAxis: {
        categories: ['00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23']
    },
    yAxis: {
        title: {
            text: 'KW'
        }
    },
    plotOptions: {
        line: {
            dataLabels: {
                enabled: false
            },
            enableMouseTracking: true
        }
    },
    series: [{
        name: 'Keskmine',
        data: [
<?php foreach ($list4 as $value) {
    echo $value . ", ";
}?>
              ]
            }, {
        name: 'Valitud päev',
        data: []
    }]
});
let monthchart = Highcharts.chart('chartContainer4', {
    chart: {
        type: 'line'
    },
    title: {
        text: 'Elektrikasutus kuu lõikes'
    },
    xAxis: {
        categories: [
<?php foreach ($list5 as $key => $value) {
    echo $key+1 . ", ";
}
?>
        ]
    },
    yAxis: {
        title: {
            text: 'KW'
        }
    },
    plotOptions: {
        line: {
            dataLabels: {
                enabled: false
            },
            enableMouseTracking: true
        }
    },
    series: [{
        name: 'Kokku',
        data: [
<?php foreach ($list5 as $value) {
    echo $value . ", ";
}
?>
              ]
    }]
});
$('#datepicker1').change(function () {
    let weekselection = document.getElementById("datepicker1").value;
$.ajax({
      url: "getweek.php",
      type: "POST",
      data: {"week": weekselection, "file": file},
      dataType : "json",
      success: function(msg){
        weekchart.series[1].setData([msg[0], msg[1], msg[2], msg[3], msg[4], msg[5], msg[6]]);
      },
        error: function() {
            weekchart.series[1].setData();
        }
   })
});

$('#datepicker').change(function () {
    let dayselection = document.getElementById("datepicker").value;
    console.log(dayselection)
$.ajax({
      url: "getday.php",
      type: "POST",
      data: {"day": dayselection, "file": file},
      dataType : "json",
      success: function(msg){
        daychart.series[1].setData([msg[0], msg[1], msg[2], msg[3], msg[4], msg[5], msg[6], msg[7], msg[8], msg[9], msg[10], msg[11], msg[12], msg[13], msg[14], msg[15], msg[16], msg[17], msg[18], msg[19], msg[20], msg[21], msg[22], msg[23]]);
      },
        error: function() {
            daychart.series[1].setData();
        }
   })
});

$('#datepicker2').change(function () {
    let dateselection = document.getElementById("datepicker2").value;
$.ajax({
      url: "getmonth.php",
      type: "POST",
      data: {"date": dateselection, "file": file},
      dataType : "json",
      success: function(msg){
        monthchart.series[0].setData([msg[0], msg[1], msg[2], msg[3], msg[4], msg[5], msg[6], msg[7], msg[8], msg[9], msg[10], msg[11], msg[12], msg[13], msg[14], msg[15], msg[16], msg[17], msg[18], msg[19], msg[20], msg[21], msg[22], msg[23], msg[24], msg[25], msg[26], msg[27], msg[28], msg[29], msg[30], msg[31]]);
      },
        error: function() {
            monthchart.series[0].setData();
        }
   })
});
</script>
