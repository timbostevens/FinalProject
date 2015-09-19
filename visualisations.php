<!-- php script to generate stats -->
<?php    
    try{// gets stats and connection
    include("php/visStats.php");
} catch (PDOException $ex){

    // if there is a database error set all the stats to 0
    $totalJourneys=0;
    $averageSpeed=0;
    $totalTime=0;
    $averageTime=0;
    $totalDistance=0;
    $averageDistance=0;
    $totalPetrol=0;
    $averagePetrol=0;
    $totalCo2=0;
    $averageCo2=0;
}
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
  <meta name="description" content="QUB Electic DeLorean Project - Summary Data">
  <meta name="author" content="">
  <meta name="keywords" content="Electric, DeLorean, Car, QUB, Queen's University Belfast, Journey, Data, Map, Chart, Graph">
    <link rel="icon" href="img/qubev.ico">

	<title>QUBEV</title>

	<!-- Bootstrap core CSS -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<!-- Custom styles for this template -->
	<link href="css/styles.css" rel="stylesheet">
	<!-- Custom Fonts for pill symbols-->
	<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

<!-- Prefetch links for all modern browsers -->
  <link rel="prefetch prerender" href="http://tstevens01.students.cs.qub.ac.uk/index.html" >
  <link rel="prefetch prerender" href="http://tstevens01.students.cs.qub.ac.uk/journeys.php" >
  <link rel="prefetch prerender" href="http://tstevens01.students.cs.qub.ac.uk/about.html" >


</head>

    <body onload="sidebar()">

      <!-- Facebook plugin setup -->
      <div id="fb-root"></div>
      <!-- Social SDK setup -->
      <script type="text/javascript" src="js/socialSetup.js"></script>


    	<!-- Navbar -->

    	<nav class="navbar navbar-default navbar-fixed-top">
    		<div class="container-fluid">
    			<div class="row">

    				<!--first column to hold recent journeys text-->
    				<div class="col-md-2 col-sm-3" id="navbar-recent">
    					<div>
    						<h6>SOCIAL</h6>

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
    						<a class="navbar-brand" href="index.html">QUBEV</a>

                            <a class = "nav-social" href="https://twitter.com/intent/follow?screen_name=QUBDeLorean"><img src="img/twitter_white_nav.png" /></a>

                            <a class = "nav-social" href="https://www.facebook.com/QUBEV"><img src="img/facebook_white_nav.png" /></a>
                            
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
            <ul class="nav nav-sidebar" id="sidebar-main">

                  <li><div id="sidebar-twitter-header">twitter</div></li>
                  
                  <li id="twitter-holder" class="social-holder">

                    <a class="twitter-timeline" data-dnt="true" href="https://twitter.com/QUBDeLorean" data-widget-id="622021958096564224" width="100%" height="100%" data-chrome="noborders">Tweets by @QUBDeLorean</a>

                  </li>

                  <li><div id="sidebar-facebook-header">facebook</div></li>

                  <li id="facebook-holder" class="social-holder">

                    <div class="fb-page" data-href="https://www.facebook.com/QUBEV?_rdr=p" data-width="500" data-height="400" data-small-header="true" data-adapt-container-width="true" data-hide-cover="true" data-show-facepile="false" data-show-posts="true"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/QUBEV?_rdr=p"><a href="https://www.facebook.com/QUBEV?_rdr=p">QUB Electric DeLorean</a></blockquote></div></div>                      

                  </li>

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
                                                <div>TOTAL CO<sub>2</sub> SAVED</div>
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
                                                <div>AVERAGE CO<sub>2</sub> SAVED</div>
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
					    <div id="dashboard_div" class="vis-chart-container-beside">

					    <div id="scatter_div" style="height: 500px; width: 100%"></div>

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
                        <div class="vis-chart-container-beside">
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

    <!--Load the Google Charts AJAX API -->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <!-- <script src="js/ie10-viewport-bug-workaround.js"></script> -->
              <!-- twitter widget -->
    <script src="https://platform.twitter.com/widgets.js"></script>
    <!-- Script to size facebook and twitter widgets also contains ie10 workaround-->
    <script src="js/allPages.js" type="text/javascript"></script>
    <!-- Load heatmap api -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=visualization&sensor=true_or_false">
    </script>
            <!-- Code for all charts -->
    <script type="text/javascript" src="js/visChartLoad.js"></script>


</body>




</html>
