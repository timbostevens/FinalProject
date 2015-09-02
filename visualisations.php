<!-- IS THIS INSECURE/BAD PRACTICE? -->
<!-- http://stackoverflow.com/questions/23740548/how-to-pass-variables-and-data-from-php-to-javascript -->
<!-- php script to generate stats -->
<?php    
    // gets stats and connection
    include("visStats.php");
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


      <!--Load the Google Charts AJAX API -->
      <script type="text/javascript" src="https://www.google.com/jsapi"></script>

        <!-- Load core chart script-->
  <script type="text/javascript" src="charts/chartLoaderVis.js"></script>

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
    				<!-- <div id="vis-top"> -->
    					<!-- <div class="container"> -->
    						<!-- <h2>visualisations</h2> -->


    						<!-- Single button -->
<!--     						<div class="btn-group" id="date-select">
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
    						</div> -->

    					<!-- </div> -->
    				<!-- </div> -->

    				<div class="pill-holder">
    					

    					<!-- first row of pills -->

    					<div class="row">


    						<div class="col-md-4">
    							<div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <i class="fa fa-car fa-3x"></i>
                                            </div>
                                            <div class="col-xs-9 text-right">
                                                <div class="vis-huge"><?php echo($totalJourneys); ?></div>
                                                <div>JOURNEYS</div>
                                            </div>
                                        </div>
                                    </div>
<!--                                     <a href="#">
                                        <div class="panel-footer">
                                            <span class="pull-left">show visualisations</span>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </a> -->
                                </div>
    						</div>



    						<div class="col-md-4">
    							<div class="panel panel-yellow">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <i class="fa fa-clock-o fa-3x"></i>
                                            </div>
                                            <div class="col-xs-9 text-right">
                                                <div class="vis-huge"><?php echo($totalTime." mins"); ?></div>
                                                <div>TOTAL DURATION</div>
                                            </div>
                                        </div>
                                    </div>
<!--                                     <a href="#">
                                        <div class="panel-footer">
                                            <span class="pull-left">show visualisations</span>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </a> -->
                                </div>
    						</div>


    						<div class="col-md-4">
    							<div class="panel panel-yellow">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <i class="fa fa-clock-o fa-3x"></i>
                                            </div>
                                            <div class="col-xs-9 text-right">
                                                <div class="vis-huge"><?php echo($averageTime." mins"); ?></div>
                                                <div>AVERAGE DURATION</div>
                                            </div>
                                        </div>
                                    </div>
<!--                                     <a href="#">
                                        <div class="panel-footer">
                                            <span class="pull-left">show visualisations</span>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </a> -->
                                </div>
    						</div>



    					</div> <!-- end first row of pills -->

                        <!-- second row of pills -->

                        <div class="row">


                            <div class="col-md-4">
                                <div class="panel panel-green">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <i class="fa fa-car fa-3x"></i>
                                            </div>
                                            <div class="col-xs-9 text-right">
                                                <div class="vis-huge"><?php echo($averageSpeed." mph"); ?></div>
                                                <div>AVERAGE SPEED</div>
                                            </div>
                                        </div>
                                    </div>
<!--                                     <a href="#">
                                        <div class="panel-footer">
                                            <span class="pull-left">show visualisations</span>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </a> -->
                                </div>
                            </div>



                            <div class="col-md-4">
                                <div class="panel panel-red">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <i class="fa fa-power-off fa-3x"></i>
                                            </div>
                                            <div class="col-xs-9 text-right">
                                                <div class="vis-huge"><?php echo($totalCo2." kg"); ?></div>
                                                <div>TOTAL CO2 SAVED</div>
                                            </div>
                                        </div>
                                    </div>
<!--                                     <a href="#">
                                        <div class="panel-footer">
                                            <span class="pull-left">show visualisations</span>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </a> -->
                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="panel panel-red">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <i class="fa fa-power-off fa-3x"></i>
                                            </div>
                                            <div class="col-xs-9 text-right">
                                                <div class="vis-huge"><?php echo($averageCo2." kg"); ?></div>
                                                <div>AVERAGE CO2 SAVED</div>
                                            </div>
                                        </div>
                                    </div>
<!--                                     <a href="#">
                                        <div class="panel-footer">
                                            <span class="pull-left">show visualisations</span>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </a> -->
                                </div>
                            </div>



                        </div> <!-- end second row of pills -->
                        

                        <!-- third row of pills -->
                        <div class="row">

                            <div class="col-lg-3 col-md-6">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <i class="fa fa-road fa-3x"></i>
                                            </div>
                                            <div class="col-xs-9 text-right">
                                                <div class="vis-huge"><?php echo($totalDistance." mi"); ?></div>
                                                <div>TOTAL DISTANCE</div>
                                            </div>
                                        </div>
                                    </div>
<!--                                     <a href="#">
                                        <div class="panel-footer">
                                            <span class="pull-left">show visualisations</span>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </a> -->
                                </div>
                            </div>



                            <div class="col-lg-3 col-md-6">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <i class="fa fa-road fa-3x"></i>
                                            </div>
                                            <div class="col-xs-9 text-right">
                                                <div class="vis-huge"><?php echo($averageDistance." mi"); ?></div>
                                                <div>AVERAGE DISTANCE</div>
                                            </div>
                                        </div>
                                    </div>
<!--                                     <a href="#">
                                        <div class="panel-footer">
                                            <span class="pull-left">show visualisations</span>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </a> -->
                                </div>
                            </div>



                            <div class="col-lg-3 col-md-6">
                                <div class="panel panel-green">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <i class="fa fa-bolt fa-3x"></i>
                                            </div>
                                            <div class="col-xs-9 text-right">
                                                <div class="vis-huge"><?php echo($totalPetrol." L"); ?></div>
                                                <div>TOTAL PETROL SAVED</div>
                                            </div>
                                        </div>
                                    </div>
<!--                                     <a href="#">
                                        <div class="panel-footer">
                                            <span class="pull-left">show visualisations</span>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </a> -->
                                </div>
                            </div>



                            <div class="col-lg-3 col-md-6">
                                <div class="panel panel-green">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <i class="fa fa-bolt fa-3x"></i>
                                            </div>
                                            <div class="col-xs-9 text-right">
                                                <div class="vis-huge"><?php echo($averagePetrol." L"); ?></div>
                                                <div>AVERAGE PETROL SAVED</div>
                                            </div>
                                        </div>
                                    </div>
<!--                                     <a href="#">
                                        <div class="panel-footer">
                                            <span class="pull-left">show visualisations</span>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </a> -->
                                </div>
                            </div>



                        </div> <!-- end first row of pills -->
    				</div> <!-- end pill holder -->


    				<div class="row">


    					<div class="col-md-6">

    					<!--Div that will hold the scatterchart dashboard-->
					    <div id="dashboard_div" class="vis-chart-container-l">

					    <div id="chart_div" style="height: 500px; width: 100%"></div>

					      <div class="btn-group chart-button">
					        <button type="button" class="btn btn-default btn-xs dropdown-toggle dropdown-text" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					            HORIZONTAL AXIS <span class="caret"></span>
					          </button>
					          <ul class="dropdown-menu">
					            <li><a class="scat-horiz-select dropdown-text">Speed (mph)</a></li>
					            <li><a class="scat-horiz-select dropdown-text">Distance (mi)</a></li>
					            <li><a class="scat-horiz-select dropdown-text">Duration (mins)</a></li>                          
					            <li><a class="scat-horiz-select dropdown-text">Petrol Saved (L)</a></li>
					            <li><a class="scat-horiz-select dropdown-text">CO2 Saved (kg)</a></li>
					          </ul>
					        </div>

					        <div class="btn-group chart-button">
					          <button type="button" class="btn btn-default btn-xs dropdown-toggle dropdown-text" data-toggle="dropdown" id="y-select" aria-haspopup="true" aria-expanded="false">
					              VERTICAL AXIS <span class="caret"></span>
					            </button>
					            <ul class="dropdown-menu">
					            <li><a class="scat-vert-select dropdown-text">Speed (mph)</a></li>
					            <li><a class="scat-vert-select dropdown-text">Distance (mi)</a></li>
					            <li><a class="scat-vert-select dropdown-text">Duration (mins)</a></li>                          
					            <li><a class="scat-vert-select dropdown-text">Petrol Saved (L)</a></li>
					            <li><a class="scat-vert-select dropdown-text">CO2 Saved (kg)</a></li>
					            </ul>
					          </div>


                            <!-- CURRENTLY HIDING ALL FILTERS -->

					      <!--Divs that will hold each control and chart-->
					      <div id="speed_filter_div" style="display:none"></div>
					      <div id="distance_filter_div" style="display:none"></div>
					      <div id="duration_filter_div" style="display:none"></div>
					      <div id="petrol_filter_div" style="display:none"></div>
					      <div id="co2_filter_div" style="display:none"></div>
					      

					    </div>

    					</div> <!-- end first chart column -->



    					<div class="col-md-6">
    					<!-- 	<h5>SECOND CHART</h5> -->
                        <div class="vis-chart-container-r">
    						<!-- Google Chart Example -->
    						<!--Div that will hold the histogram-->
    						<div id="histo_div" style="height: 500px; width: 100%"></div>
    						     
					      <div class="btn-group chart-button">
					        <button type="button" class="btn btn-default btn-xs dropdown-toggle dropdown-text" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					            DATA <span class="caret"></span>
					          </button>
					          <ul class="dropdown-menu">
					            <li><a class="hist-select dropdown-text">Speed (mph)</a></li>
					            <li><a class="hist-select dropdown-text">Distance (mi)</a></li>
					            <li><a class="hist-select dropdown-text">Duration (mins)</a></li>                          
					            <li><a class="hist-select dropdown-text">Petrol Saved (L)</a></li>
					            <li><a class="hist-select dropdown-text">CO2 Saved (kg)</a></li>
					          </ul>
					        </div>

    					</div> <!-- end second chart column -->

                        </div> <!--end column -->
    				</div> <!-- end first chart row -->



    				<div class="row">
    					<div class="col-md-12">

                            <div class="vis-bubble-container">
                            <!--Div that will hold the bubble chart-->
                            <div id="bubble_div" style="height: 500px; width: 100%"></div>
                            </div>
    					</div>
    				</div>

                    <!-- spacer -->
                    <!-- <div style="width: 100%; height:30px;"></div> -->

                    <!-- <div class="row"> -->
                        <!-- <div class="col-md-2"> -->
                            
                            
                        <!-- </div> -->
                        <!-- <div class="col-md-8"> -->
                            
                            <!--Div that will hold the calendar chart-->
                            <!-- <div id="calendar_chart_div" style="height: 360px; width 1500px"></div> -->
                            
                        <!-- </div> -->
                        <!-- <div class="col-md-2"> -->

                            
                        <!-- </div> -->
                    <!-- </div> -->

                    <div class="row">
                        <div class="col-md-12">
                        <!-- Jumbotron to set it in from the edge -->
                            <div class = "vis-chart-container">
                                
                            <!--Div that will hold the heatmap-->
                            <div id="heatmap-canvas" style="height: 700px"></div>

                            </div>
                           
                            
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
    <!-- Load heatmap api -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=visualization&sensor=true_or_false">
    </script>
    <!-- Code for Ajax Helper -->
    <script type="text/javascript" src="ajaxHelper.js"></script>
    <!-- Code for scatterChart -->
    <script type="text/javascript" src="charts/scatterChartLoad.js"></script>
    <!-- Code for histoChart -->
    <script type="text/javascript" src="charts/histoChartLoad.js"></script>
    <!-- Code for histoChart -->
    <script type="text/javascript" src="charts/bubbleChartLoad.js"></script>
    <!-- Code for Calendar Chart -->
    <script type="text/javascript" src="charts/calendarChartLoad.js"></script>
        <!-- Code for Heatmap Chart -->
    <script type="text/javascript" src="charts/heatmapLoad.js"></script>
</body>




</html>
