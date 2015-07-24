<!-- php script to generate stats -->
<?php

    /*
    NEED SOME MANAGEMNET FOR DATABASE FAILURE
    */
    
    // gets connection details
    include("connection.php");
    // sql query to count journeys
    $query="SELECT COUNT(*) AS 'count' FROM jour";
    // runs the query and sets to variable
    $result = mysqli_query($connection,$query);
    // gets the first row (all that is needed for this one)
    $row = mysqli_fetch_array($result);
    // extracts value from first row
    $journeyCount=$row['count'];

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Download font from google -->
	<link href='http://fonts.googleapis.com/css?family=Biryani' rel='stylesheet' type='text/css'>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="icon" href="favicon.ico">

	<title>Tim's Dashboard Test</title>

	<!-- Bootstrap core CSS -->
	<link href="css/bootstrap.min.css" rel="stylesheet">

	<!-- Custom styles for this template -->
	<link href="styles.css" rel="stylesheet">

	<!-- Custom Fonts for pill symbols-->
	<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">


	<!-- Load d3 charts WHERE IS THE BEST PLACE TO PUT THIS?-->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.5/d3.min.js"></script>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->


      <!--Load the Google Charts AJAX API (Pie Chart) -->
      <script type="text/javascript" src="https://www.google.com/jsapi"></script>

      <!-- Sample Google chart code (Pie Chart) -->
      <script type="text/javascript" src="sampleGoogleChartPie.js"></script>

      <!--Load the Google Charts AJAX API (Line Graph) -->
<!--     <script type="text/javascript"
          src="https://www.google.com/jsapi?autoload={
            'modules':[{
              'name':'visualization',
              'version':'1',
              'packages':['corechart']
            }]
        }"></script>   -->

        <script type="text/javascript" src="sampleGoogleChartLine.js"></script>

    </head>

    <body>


    	<!-- Navbar -->

    	<nav class="navbar navbar-default navbar-fixed-top">
    		<div class="container-fluid">
    			<div class="row">

    				<!--first column to hold recent journeys text-->
    				<div class="col-md-2 col-sm-3" id="navbar-recent">
    					<div>
    						<h6>JOURNEYS</h6>

    					</div>
    				</div>

    				<!--second column to hold main navbar contents -->
    				<div class="col-md-10 col-sm-9 col-xs-12">


    					<div class="navbar-header">
    						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
    							<span class="sr-only">Toggle navigation</span>
    							<span class="icon-bar"></span>
    							<span class="icon-bar"></span>
    							<span class="icon-bar"></span>
    						</button>
    						<a class="navbar-brand" href="index.html">DeLOREAN PROJECT</a>
    					</div>
    					<div id="navbar" class="navbar-collapse collapse">
    						<ul class="nav navbar-nav navbar-right">
    							<li><a href="journeys.php">journeys</a></li>
    							<li class="active"><a href="#">visualsations</a></li>
    							<li><a href="about.html">about</a></li>
    						</ul>
    					</div>



    				</div>



    			</div>
    		</div>
    	</nav> <!-- End Navbar -->



    	<!--main panel split into two (sidebar and main)-->

    	<div class="container-fluid centralised-text">
    		<div class="row">



    			<!-- Sidebar -->
    			<div class="col-sm-3 col-md-2 sidebar">
    				<ul class="nav nav-sidebar">

    					<!-- Sidebar entry -->
    					<li><a href="#">              
    						<div>
    							<img src="img/sampleMap02.jpg" class="img-responsive">
    							<h6>12th SEPTEMBER 2013<br/>14 km</h6>
    						</div>
    					</a></li> <!-- End sidebar entry -->
    					<hr/>
    					<li><a href="#">              
    						<div>
    							<img src="img/sampleMap02.jpg" class="img-responsive">
    							<h6>12th SEPTEMBER 2013<br/>14 km</h6>
    						</div>
    					</a></li> <!-- End sidebar entry -->
    					<hr/>
    					<li><a href="#">              
    						<div>
    							<img src="img/sampleMap02.jpg" class="img-responsive">
    							<h6>12th SEPTEMBER 2013<br/>14 km</h6>
    						</div>
    					</a></li> <!-- End sidebar entry -->
    					<hr/>
    					<li><a href="#">              
    						<div>
    							<img src="img/sampleMap02.jpg" class="img-responsive">
    							<h6>12th SEPTEMBER 2013<br/>14 km</h6>
    						</div>
    					</a></li> <!-- End sidebar entry -->
    					<hr/>
    					<li><a href="#">              
    						<div>
    							<img src="img/sampleMap02.jpg" class="img-responsive">
    							<h6>12th SEPTEMBER 2013<br/>14 km</h6>
    						</div>
    					</a></li> <!-- End sidebar entry -->
    					<hr/>
    					<li><a href="#">more journeys</a></li>
    					<!-- End sidebar entry -->
    				</ul>

    			</div> <!-- End Sidebar -->


    			<!-- Main Content -->
    			<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">


    				<!-- set up  jumbotron container -->
    				<div id="middle">
    					<div class="container">
    						<h2>visualisations</h2>


    						<!-- Single button -->
    						<div class="btn-group" id="date-select">
    						<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" id="date-select" aria-haspopup="true" aria-expanded="false">
    								SELECT DATE <span class="caret"></span>
    							</button>
    							<ul class="dropdown-menu">
    								<li><a href="#">THIS WEEK</a></li>
    								<li><a href="#">THIS MONTH</a></li>
    								<li><a href="#">THIS YEAR</a></li>
    								<li role="separator" class="divider"></li>
    								<li><a href="#">CUSTOM DATE</a></li>
    							</ul>
    						</div>

    					</div>
    				</div>

    				<div class="pill-holder">
    					<!-- first row of pills -->
                     	<div class="row">

    						<div class="col-lg-3 col-md-6">
    							<div class="panel panel-primary">
    								<div class="panel-heading">
    									<div class="row">
    										<div class="col-xs-3">
    											<i class="fa fa-car fa-5x"></i>
    										</div>
    										<div class="col-xs-9 text-right">
    											<div class="vis-huge"><?php echo($journeyCount); ?></div>
    											<div>JOURNEYS</div>
    										</div>
    									</div>
    								</div>
    								<a href="#">
    									<div class="panel-footer">
    										<span class="pull-left">show visualisations</span>
    										<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
    										<div class="clearfix"></div>
    									</div>
    								</a>
    							</div>
    						</div>



    						<div class="col-lg-3 col-md-6">
    							<div class="panel panel-green">
    								<div class="panel-heading">
    									<div class="row">
    										<div class="col-xs-3">
    											<i class="fa fa-road fa-5x"></i>
    										</div>
    										<div class="col-xs-9 text-right">
    											<div class="vis-huge">124 km</div>
    											<div>DRIVEN</div>
    										</div>
    									</div>
    								</div>
    								<a href="#">
    									<div class="panel-footer">
    										<span class="pull-left">show visualisations</span>
    										<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
    										<div class="clearfix"></div>
    									</div>
    								</a>
    							</div>
    						</div>



    						<div class="col-lg-3 col-md-6">
    							<div class="panel panel-yellow">
    								<div class="panel-heading">
    									<div class="row">
    										<div class="col-xs-3">
    											<i class="fa fa-clock-o fa-5x"></i>
    										</div>
    										<div class="col-xs-9 text-right">
    											<div class="vis-huge">124 hrs</div>
    											<div>DURATION</div>
    										</div>
    									</div>
    								</div>
    								<a href="#">
    									<div class="panel-footer">
    										<span class="pull-left">show visualisations</span>
    										<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
    										<div class="clearfix"></div>
    									</div>
    								</a>
    							</div>
    						</div>



    						<div class="col-lg-3 col-md-6">
    							<div class="panel panel-red">
    								<div class="panel-heading">
    									<div class="row">
    										<div class="col-xs-3">
    											<i class="fa fa-support fa-5x"></i>
    										</div>
    										<div class="col-xs-9 text-right">
    											<div class="vis-huge">13</div>
    											<div>OTHER STAT</div>
    										</div>
    									</div>
    								</div>
    								<a href="#">
    									<div class="panel-footer">
    										<span class="pull-left">show visualisations</span>
    										<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
    										<div class="clearfix"></div>
    									</div>
    								</a>
    							</div>
    						</div>



    					</div> <!-- end first row of pills -->

    					<!-- second row of pills -->

    					<div class="row">


    						<div class="col-md-4">
    							<div class="panel panel-primary">
    								<div class="panel-heading">
    									<div class="row">
    										<div class="col-xs-3">
    											<i class="fa fa-cloud fa-5x"></i>
    										</div>
    										<div class="col-xs-9 text-right">
    											<div class="vis-huge">267 g</div>
    											<div>CO2 SAVED</div>
    										</div>
    									</div>
    								</div>
    								<a href="#">
    									<div class="panel-footer">
    										<span class="pull-left">show visualisations</span>
    										<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
    										<div class="clearfix"></div>
    									</div>
    								</a>
    							</div>
    						</div>



    						<div class="col-md-4">
    							<div class="panel panel-green">
    								<div class="panel-heading">
    									<div class="row">
    										<div class="col-xs-3">
    											<i class="fa fa-bolt fa-5x"></i>
    										</div>
    										<div class="col-xs-9 text-right">
    											<div class="vis-huge">34</div>
    											<div>BATTERY CHARGES</div>
    										</div>
    									</div>
    								</div>
    								<a href="#">
    									<div class="panel-footer">
    										<span class="pull-left">show visualisations</span>
    										<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
    										<div class="clearfix"></div>
    									</div>
    								</a>
    							</div>
    						</div>


    						<div class="col-md-4">
    							<div class="panel panel-red">
    								<div class="panel-heading">
    									<div class="row">
    										<div class="col-xs-3">
    											<i class="fa fa-power-off fa-5x"></i>
    										</div>
    										<div class="col-xs-9 text-right">
    											<div class="vis-huge">1345 kWh</div>
    											<div>ENERGY SAVED</div>
    										</div>
    									</div>
    								</div>
    								<a href="#">
    									<div class="panel-footer">
    										<span class="pull-left">show visualisations</span>
    										<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
    										<div class="clearfix"></div>
    									</div>
    								</a>
    							</div>
    						</div>



    					</div> <!-- end second row of pills -->
    				</div> <!-- end pill holder -->


    				<div class="row">


    					<div class="col-md-4">

    						<h5>FIRST CHART</h5>

    						<!-- Chart 1 Using HTML -->

    						<div class="chart" id="chart-container"></div>

    						<script>

    							var data = [4, 8, 15, 16, 23, 42];

    							var x = d3.scale.linear()
    							.domain([0, d3.max(data)])
    							.range([0, 420]);

    							d3.select(".chart")
    							.selectAll("div")
    							.data(data)
    							.enter().append("div")
    							.style("width", function(d) { return x(d) + "px"; })
    							.text(function(d) { return d; });

    						</script>
    					</div> <!-- end first chart column -->



    					<div class="col-md-4">
    						<h5>SECOND CHART</h5>

    						<!-- Google Chart Example -->
    						<!--Div that will hold the pie chart-->
    						<div id="chart_div"></div>

    					</div> <!-- end second chart column -->


    					<div class="col-md-4">
    						<h5>THIRD CHART</h5>
    					</div> <!-- end third chart column -->


    				</div> <!-- end first chart row -->

    				<div class="row">
    					<div class="col-md-12">
    						<h5>BIG WIDE CHART</h5>
    						<div id="curve_chart" style="height: 500px"></div>
    					</div>


    				</div>




    			</div> <!-- End Main Content -->
    		</div> <!-- End Row -->

    	</div> <!-- End container-->

    	<footer class="footer">
    		<div class="container" id="footer-container">

    			<img src="img/QueensLogo02.png" class="img-responsive" id="footer-logo"/>
    			<p id="footer-text">phone: (028) 9012 3456<br/><a href="mailto:delorean@qub.ac.uk">delorean@qub.ac.uk</a></p>
    		</div>
    	</footer>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>




</body>




</html>
