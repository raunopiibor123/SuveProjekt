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
    
?>
<div class="container">
  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#Raport1">Raport 1</a></li>
    <li><a data-toggle="tab" href="#Raport2">Raport 2</a></li>
    <li><a data-toggle="tab" href="#Raport3">Raport 3</a></li>
    <li><a data-toggle="tab" href="#Raport4">Raport 4</a></li>
    <button type="button" class="btn btn-primary btn-md" style="margin-top:4px" data-toggle="modal" data-target="#newRaportModal">Create New</button>
  </ul>

  <div class="tab-content">
    <div id="Raport1" class="tab-pane fade in active">
      <div id="chartContainer" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
    </div>
    <div id="Raport2" class="tab-pane fade">
      <h3>Raport 2</h3>
      <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
    </div>
    <div id="Raport3" class="tab-pane fade">
      <h3>Raport 3</h3>
      <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
    </div>
    <div id="Raport4" class="tab-pane fade">
      <h3>Raport 4</h3>
      <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
    </div>
  </div>
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
        data: [7.0, 6.9, 9.5, 14.5, 18.4, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
    }, {
        name: 'Optimal',
        data: [3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]
    }]
});
</script>