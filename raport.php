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
    
    require_once("classes/ParseCSV.class.php");
    $csvClass = new CSV("csv/tarbimisteatis.csv");
    $list = $csvClass->getMonthlyValues("2017");
    $list2 = $csvClass->getYearlyValues();
    $list3 = $csvClass->getWeeklyValues();
    $list4 = $csvClass->getDailyValues();
?>
<div class="container">
<div id="chartContainer1" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<div id="chartContainer" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<div id="chartContainer2" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<div id="chartContainer3" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
</div>

<script>
Highcharts.chart('chartContainer', {
    chart: {
        type: 'line'
    },
    title: {
        text: 'Monthly Electricity Usage'
    },
    subtitle: {
        text: 'Source: You'
    },
    xAxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
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
        }
    },
    series: [{
        name: 'Yours',
        data: [
                <?php foreach($list as $value){
                    echo $value . ", ";
                }?>
              ]
    }]
});

Highcharts.chart('chartContainer1', {
    chart: {
        zoomType: 'x'
    },
    title: {
        text: 'Yearly Electricity Usage'
    },
    xAxis: {
        categories: [                
                <?php 
                $valueArray = $list2[1];
                foreach($valueArray as $value){
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
        name: 'Yours',
        type: 'column',
        data:   [
                <?php 
                $valueArray = $list2[0];
                foreach($valueArray as $value){
                echo $value . ", ";
                }?>
                ]
    }]
});

Highcharts.chart('chartContainer2', {
    chart: {
        zoomType: 'x'
    },
    title: {
        text: 'Average Electricity Usage on Weekdays'
    },
    xAxis: {
        categories: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']
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
        name: 'Yours',
        type: 'column',
        data:   [
                <?php 
                foreach($list3 as $value){
                echo $value . ", ";
                }?>
                ]
    }]
});

Highcharts.chart('chartContainer3', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Electricity Usage by Time of Day'
    },
    subtitle: {
        text: 'Source: You'
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
                enabled: true
            },
            enableMouseTracking: false
        }
    },
    series: [{
        name: 'Yours',
        data: [
                <?php foreach($list4 as $value){
                    echo $value . ", ";
                }?>
              ]
    }]
});
</script>
