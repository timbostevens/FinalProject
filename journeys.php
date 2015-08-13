<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Download fint from google -->
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

  <!--Load the Google Charts AJAX API -->
  <script type="text/javascript" src="https://www.google.com/jsapi"></script>

  <!-- Load core chart scrip-->
  <script type="text/javascript" src="charts/googleCoreCharts.js"></script>

      <!-- Google Chart Code -->
    <!-- <script type="text/javascript" src="charts/journeysArea.js"></script> -->


    <!-- <script type="text/javascript" src="charts/sampleGoogleChartLine.js"></script> -->

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
    </head>
    
    <body onload="setupAccordion()">
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
                  <li class="active"><a href="#">journeys</a></li>
                  <li><a href="visualisations.php">visualsations</a></li>
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
            <div class="jumbotron" id="middle">
              <div class="container">
                <h3>JOURNEYS</h3>
         
                <!-- set up accordion list -->
                <!-- <div class="bs-example"> -->
                  <div class="panel-group" id="accordion">
                   

                    <!-- This is the first accordion entry -->
                    <div class="panel panel-default accordion-panel" id="panel1">
                      <!-- Panel Header -->
                      <div class="panel-heading">
                        <h4 class="panel-title">
                          <!-- href set as journey number -->
                          <a id="panelLink1" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                            <div class="row">
                              <div class="col-md-8">
                                <p class="accordion-title" id="journeyP1">Journey x</p>
                                <p id="dateP1">Date x</p>
                                <p id="startP1">Start x</p>
                                <p><small>13 km</small></p>



                              </div>
                              <div class="col-md-4">
                                <img src="img/sampleMap02.jpg" id="panel-static-image1"/>
                              </div>
                            </a>
                          </h4>
                        </div>
                        <!-- Main Panel Body -->
                        <!-- id set as journey number (used lated when clicked to load map) -->
                        <div id="collapseOne" class="panel-collapse collapse">
                          <div class="panel-body">
                            <div class = "googlemap">
                              <div id="mapcanvas1" style="width: 100%; height: 300px;"></div>
                            </div>
                          
                            <!-- <div class="row"> -->
                                <!-- <div class="col-md-12"> -->
                                  <!-- large horizontal chart -->
                                    <div id="journey-area-chart1" style="width: 100%; height: 300px"></div>

                                <!-- </div> -->
                            <!-- </div> -->



                            <div class="row">
                              <!-- Left hand column containing stat list -->

                        <!-- MIGHT WANT TO DO THIS AS A LIST OF BUTTONS
                        THIS WILL PRE-SET HIGHLIGHTING OF CURRENT CHOICE -->
                        <div class="col-md-6 box">
                          

                          <p>Start Time: <span id="start-stat1">xxxxxx</span></p>

                          <p>End Time: <span id="end-stat1">xxxxxx</span></p>

                          <p> Distance: <span id="distance-stat1">xxxxxx</span> miles<button type="button" class="btn btn-link btn-xs">
                            <span class="glyphicon glyphicon-stats large" id="distStat" aria-hidden="true"></span></button></p>

                          <p>Duration: <span id="duration-stat1">xxxxxx</span> minutes<button type="button" class="btn btn-link btn-xs">
                              <span class="glyphicon glyphicon-stats large" id="durStat" aria-hidden="true"></span></button></p>

                          <p>Speed: <span id="speed-stat1">xxxxxx</span> mph<button type="button" class="btn btn-link btn-xs">
                                <span class="glyphicon glyphicon-stats large" id="spdStat" aria-hidden="true"></span></button></p>

                          <p>Petrol Saved: <span id="petrol-stat1">xxxxxx</span> L<button type="button" class="btn btn-link btn-xs">
                                  <span class="glyphicon glyphicon-stats large" id="enStat" aria-hidden="true"></span></button></p>

                          <p>CO2 Saved: <span id="co2-stat1">xxxxxxx</span> kg<button type="button" class="btn btn-link btn-xs">
                                    <span class="glyphicon glyphicon-stats large" id="co2Stat" aria-hidden="true"></span></button></p>


                          </div> <!-- end col-md-6 -->
                                  <!-- Right hand column containing chart -->
                            <div class="col-md-6 box">
                              
                              <!-- <div id="journey-scatter-chart1" style="width: 100%; height: 300px"></div> -->
                


<!--                             <div class="btn-group" id="x-select">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                SELECT X AXIS <span class="caret"></span>
                              </button>
                              <ul class="dropdown-menu">
                                <li><a>DISTANCE</a></li>
                                <li><a>DURATION</a></li>
                                <li><a>SPEED</a></li>                          
                                <li><a>PETROL SAVED</a></li>
                                <li><a>CO2 SAVED</a></li>

                              </ul>
                            </div> -->


                            <!-- <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                SELECT X AXIS <span class="caret"></span>
                              </button>
                              <ul class="dropdown-menu">
                                <li><a class="x-select">DISTANCE</a></li>
                                <li><a class="x-select">DURATION</a></li>
                                <li><a class="x-select">SPEED</a></li>                          
                                <li><a class="x-select">PETROL SAVED</a></li>
                                <li><a class="x-select">CO2 SAVED</a></li>

                              </ul>
                            </div>

                            <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" id="y-select" aria-haspopup="true" aria-expanded="false">
                                SELECT Y AXIS <span class="caret"></span>
                              </button>
                              <ul class="dropdown-menu">
                                <li><a>DISTANCE</a></li>
                                <li><a>DURATION</a></li>
                                <li><a>SPEED</a></li>                          
                                <li><a>PETROL SAVED</a></li>
                                <li><a>CO2 SAVED</a></li>
                              </ul>
                            </div> -->




                            </div> <!-- end col-md-6 box-->

                          </div> <!-- end row -->

                              </div> <!-- end panel body -->
                            </div> <!-- end main panel body -->
                          </div> <!-- end first accordion -->



                          <!-- This is the second accordion entry -->
                    <div class="panel panel-default accordion-panel" id="panel2">
                      <!-- Panel Header -->
                      <div class="panel-heading">
                        <h4 class="panel-title">
                          <!-- href set as journey number -->
                          <a id="panelLink2" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                            <div class="row">
                              <div class="col-md-8">
                                <p class="accordion-title" id="journeyP2">Journey x</p>
                                <p id="dateP2">Date x</p>
                                <p id="startP2">Start x</p>
                                <p><small>13 km</small></p>
                              </div>
                              <div class="col-md-4">
                                <img src="img/sampleMap02.jpg" id="panel-static-image2"/>
                              </div>
                            </a>
                          </h4>
                        </div>
                        <!-- Main Panel Body -->
                        <!-- id set as journey number (used lated when clicked to load map) -->
                        <div id="collapseTwo" class="panel-collapse collapse">
                          <div class="panel-body">
                            <div class = "googlemap">
                              <div id="mapcanvas2" style="width: 100%; height: 300px;"></div>
                            </div>


                             <!-- <div class="row"> -->
                                <!-- <div class="col-md-12"> -->
                                  <!-- large horizontal chart -->
                                    <div id="journey-area-chart2" style="width: 100%; height: 300px"></div>

                                <!-- </div> -->
                            <!-- </div> -->


                            <div class="row">
                              <!-- Left hand column containing stat list -->

                        <!-- MIGHT WANT TO DO THIS AS A LIST OF BUTTONS
                        THIS WILL PRE-SET HIGHLIGHTING OF CURRENT CHOICE -->
                        <div class="col-md-6 box">
                          

                          <p>Start Time: <span id="start-stat2">xxxxxx</span></p>

                          <p>End Time: <span id="end-stat2">xxxxxx</span></p>

                          <p> Distance: <span id="distance-stat2">xxxxxx</span> miles<button type="button" class="btn btn-link btn-xs">
                            <span class="glyphicon glyphicon-stats large" id="distStat" aria-hidden="true"></span></button></p>

                          <p>Duration: <span id="duration-stat2">xxxxxx</span> minutes<button type="button" class="btn btn-link btn-xs">
                              <span class="glyphicon glyphicon-stats large" id="durStat" aria-hidden="true"></span></button></p>

                          <p>Speed: <span id="speed-stat2">xxxxxx</span> mph<button type="button" class="btn btn-link btn-xs">
                                <span class="glyphicon glyphicon-stats large" id="spdStat" aria-hidden="true"></span></button></p>

                          <p>Petrol Saved: <span id="petrol-stat2">xxxxxx</span> L<button type="button" class="btn btn-link btn-xs">
                                  <span class="glyphicon glyphicon-stats large" id="enStat" aria-hidden="true"></span></button></p>

                          <p>CO2 Saved: <span id="co2-stat2">xxxxxxx</span> kg<button type="button" class="btn btn-link btn-xs">
                                    <span class="glyphicon glyphicon-stats large" id="co2Stat" aria-hidden="true"></span></button></p>



                          </div> <!-- end col-md-6 -->
                                  <!-- Right hand column containing chart -->
                            <div class="col-md-6 box">
                              
                              <img src="img/sampleScatterGraphDist01.jpeg" class="img-responsive"/>

                            </div> <!-- end col-md-6 box-->

                          </div> <!-- end row -->

                              </div> <!-- end panel body -->
                            </div> <!-- end main panel body -->
                          </div> <!-- end second accordion -->


                          <!-- This is the third accordion entry -->
                    <div class="panel panel-default accordion-panel" id="panel3">
                      <!-- Panel Header -->
                      <div class="panel-heading">
                        <h4 class="panel-title">
                          <!-- href set as journey number -->
                          <a id="panelLink3" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                            <div class="row">
                              <div class="col-md-8">
                                <p class="accordion-title" id="journeyP3">Journey x</p>
                                <p id="dateP3">Date x</p>
                                <p id="startP3">Start x</p>
                                <p><small>13 km</small></p>
                              </div>
                              <div class="col-md-4">
                                <img src="img/sampleMap02.jpg" id="panel-static-image3"/>
                              </div>
                            </a>
                          </h4>
                        </div>
                        <!-- Main Panel Body -->
                        <!-- id set as journey number (used lated when clicked to load map) -->
                        <div id="collapseThree" class="panel-collapse collapse">
                          <div class="panel-body">
                            <div class = "googlemap">
                              <div id="mapcanvas3" style="width: 100%; height: 300px;"></div>
                            </div>

                            <!-- <div class="row"> -->
                                <!-- <div class="col-md-12"> -->
                                  <!-- large horizontal chart -->
                                    <div id="journey-area-chart3" style="width: 100%; height: 300px"></div>

                                <!-- </div> -->
                            <!-- </div> -->

                            <div class="row">
                              <!-- Left hand column containing stat list -->

                        <!-- MIGHT WANT TO DO THIS AS A LIST OF BUTTONS
                        THIS WILL PRE-SET HIGHLIGHTING OF CURRENT CHOICE -->
                        <div class="col-md-6 box">
                          

                          <p>Start Time: <span id="start-stat3">xxxxxx</span></p>

                          <p>End Time: <span id="end-stat3">xxxxxx</span></p>

                          <p> Distance: <span id="distance-stat3">xxxxxx</span> miles<button type="button" class="btn btn-link btn-xs">
                            <span class="glyphicon glyphicon-stats large" id="distStat" aria-hidden="true"></span></button></p>

                          <p>Duration: <span id="duration-stat3">xxxxxx</span> minutes<button type="button" class="btn btn-link btn-xs">
                              <span class="glyphicon glyphicon-stats large" id="durStat" aria-hidden="true"></span></button></p>

                          <p>Speed: <span id="speed-stat3">xxxxxx</span> mph<button type="button" class="btn btn-link btn-xs">
                                <span class="glyphicon glyphicon-stats large" id="spdStat" aria-hidden="true"></span></button></p>

                          <p>Petrol Saved: <span id="petrol-stat3">xxxxxx</span> L<button type="button" class="btn btn-link btn-xs">
                                  <span class="glyphicon glyphicon-stats large" id="enStat" aria-hidden="true"></span></button></p>

                          <p>CO2 Saved: <span id="co2-stat3">xxxxxxx</span> kg<button type="button" class="btn btn-link btn-xs">
                                    <span class="glyphicon glyphicon-stats large" id="co2Stat" aria-hidden="true"></span></button></p>



                          </div> <!-- end col-md-6 -->
                                  <!-- Right hand column containing chart -->
                            <div class="col-md-6 box">
                              
                              <img src="img/sampleScatterGraphDist01.jpeg" class="img-responsive"/>

                            </div> <!-- end col-md-6 box-->

                          </div> <!-- end row -->

                              </div> <!-- end panel body -->
                            </div> <!-- end main panel body -->
                          </div> <!-- end third accordion -->


                          <!-- This is the fourth accordion entry -->
                  <div class="panel panel-default accordion-panel" id="panel4">
                      <!-- Panel Header -->
                      <div class="panel-heading">
                        <h4 class="panel-title">
                          <!-- href set as journey number -->
                          <a id="panelLink4" data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
                            <div class="row">
                              <div class="col-md-8">
                                <p class="accordion-title" id="journeyP4">Journey x</p>
                                <p id="dateP4">Date x</p>
                                <p id="startP4">Start x</p>
                                <p><small>13 km</small></p>
                              </div>
                              <div class="col-md-4">
                                <img src="img/sampleMap02.jpg" id="panel-static-image4"/>
                              </div>
                            </a>
                          </h4>
                        </div>
                        <!-- Main Panel Body -->
                        <!-- id set as journey number (used lated when clicked to load map) -->
                        <div id="collapseFour" class="panel-collapse collapse">
                          <div class="panel-body">
                            <div class = "googlemap">
                              <div id="mapcanvas4" style="width: 100%; height: 300px;"></div>
                            </div>

                            <!-- <div class="row"> -->
                                <!-- <div class="col-md-12"> -->
                                  <!-- large horizontal chart -->
                                    <div id="journey-area-chart4" style="width: 100%; height: 300px"></div>

                                <!-- </div> -->
                            <!-- </div> -->                            

                            <div class="row">
                              <!-- Left hand column containing stat list -->

                        <!-- MIGHT WANT TO DO THIS AS A LIST OF BUTTONS
                        THIS WILL PRE-SET HIGHLIGHTING OF CURRENT CHOICE -->
                        <div class="col-md-6 box">
                          

                          <p>Start Time: <span id="start-stat4">xxxxxx</span></p>

                          <p>End Time: <span id="end-stat4">xxxxxx</span></p>

                          <p> Distance: <span id="distance-stat4">xxxxxx</span> miles<button type="button" class="btn btn-link btn-xs">
                            <span class="glyphicon glyphicon-stats large" id="distStat" aria-hidden="true"></span></button></p>

                          <p>Duration: <span id="duration-stat4">xxxxxx</span> minutes<button type="button" class="btn btn-link btn-xs">
                              <span class="glyphicon glyphicon-stats large" id="durStat" aria-hidden="true"></span></button></p>

                          <p>Speed: <span id="speed-stat4">xxxxxx</span> mph<button type="button" class="btn btn-link btn-xs">
                                <span class="glyphicon glyphicon-stats large" id="spdStat" aria-hidden="true"></span></button></p>

                          <p>Petrol Saved: <span id="petrol-stat4">xxxxxx</span> L<button type="button" class="btn btn-link btn-xs">
                                  <span class="glyphicon glyphicon-stats large" id="enStat" aria-hidden="true"></span></button></p>

                          <p>CO2 Saved: <span id="co2-stat4">xxxxxxx</span> kg<button type="button" class="btn btn-link btn-xs">
                                    <span class="glyphicon glyphicon-stats large" id="co2Stat" aria-hidden="true"></span></button></p>



                          </div> <!-- end col-md-6 -->
                                  <!-- Right hand column containing chart -->
                            <div class="col-md-6 box">
                              
                              <img src="img/sampleScatterGraphDist01.jpeg" class="img-responsive"/>

                            </div> <!-- end col-md-6 box-->

                          </div> <!-- end row -->

                              </div> <!-- end panel body -->
                            </div> <!-- end main panel body -->
                          </div> <!-- end fourth accordion -->



                          <!-- This is the fifth accordion entry -->
                    <div class="panel panel-default accordion-panel" id="panel5">
                      <!-- Panel Header -->
                      <div class="panel-heading">
                        <h4 class="panel-title">
                          <!-- href set as journey number -->
                          <a id="panelLink5" data-toggle="collapse" data-parent="#accordion" href="#collapseFive">
                            <div class="row">
                              <div class="col-md-8">
                                <p class="accordion-title" id="journeyP5">Journey x</p>
                                <p id="dateP5">Date x</p>
                                <p id="startP5">Start x</p>
                                <p><small>13 km</small></p>
                              </div>
                              <div class="col-md-4">
                                <img src="img/sampleMap02.jpg" id="panel-static-image5"/>
                              </div>
                            </a>
                          </h4>
                        </div>
                        <!-- Main Panel Body -->
                        <!-- id set as journey number (used lated when clicked to load map) -->
                        <div id="collapseFive" class="panel-collapse collapse">
                          <div class="panel-body">
                            <div class = "googlemap">
                              <div id="mapcanvas5" style="width: 100%; height: 300px;"></div>
                            </div>

                            <!-- <div class="row"> -->
                                <!-- <div class="col-md-12"> -->
                                  <!-- large horizontal chart -->
                                    <div id="journey-area-chart5" style="width: 100%; height: 300px"></div>

                                <!-- </div> -->
                            <!-- </div> -->

                            <div class="row">
                              <!-- Left hand column containing stat list -->

                        <!-- MIGHT WANT TO DO THIS AS A LIST OF BUTTONS
                        THIS WILL PRE-SET HIGHLIGHTING OF CURRENT CHOICE -->
                        <div class="col-md-6 box">
                          

                          <p>Start Time: <span id="start-stat5">xxxxxx</span></p>

                          <p>End Time: <span id="end-stat5">xxxxxx</span></p>

                          <p> Distance: <span id="distance-stat5">xxxxxx</span> miles<button type="button" class="btn btn-link btn-xs">
                            <span class="glyphicon glyphicon-stats large" id="distStat" aria-hidden="true"></span></button></p>

                          <p>Duration: <span id="duration-stat5">xxxxxx</span> minutes<button type="button" class="btn btn-link btn-xs">
                              <span class="glyphicon glyphicon-stats large" id="durStat" aria-hidden="true"></span></button></p>

                          <p>Speed: <span id="speed-stat5">xxxxxx</span> mph<button type="button" class="btn btn-link btn-xs">
                                <span class="glyphicon glyphicon-stats large" id="spdStat" aria-hidden="true"></span></button></p>

                          <p>Petrol Saved: <span id="petrol-stat5">xxxxxx</span> L<button type="button" class="btn btn-link btn-xs">
                                  <span class="glyphicon glyphicon-stats large" id="enStat" aria-hidden="true"></span></button></p>

                          <p>CO2 Saved: <span id="co2-stat5">xxxxxxx</span> kg<button type="button" class="btn btn-link btn-xs">
                                    <span class="glyphicon glyphicon-stats large" id="co2Stat" aria-hidden="true"></span></button></p>



                          </div> <!-- end col-md-6 -->
                                  <!-- Right hand column containing chart -->
                            <div class="col-md-6 box">
                              
                              <img src="img/sampleScatterGraphDist01.jpeg" class="img-responsive"/>

                            </div> <!-- end col-md-6 box-->

                          </div> <!-- end row -->

                              </div> <!-- end panel body -->
                            </div> <!-- end main panel body -->
                          </div> <!-- end fifth accordion -->




                        </div> <!-- end panel group id=accordion -->
                      <!-- </div> end bs example -->
                    </div> <!-- end container -->
                  </div> <!-- end Jumbotron -->







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
    <!-- Load Google map API -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>
    <!-- Code for Ajax Helper -->
    <script type="text/javascript" src="ajaxHelper.js"></script>
    <!-- Data loading code -->
    <script type="text/javascript" src="journeyDataload.js"></script>
        <!-- Accordion Manager -->
    <script type="text/javascript" src="accordionManager.js"></script>

    <script>
    // runs on accordion panel click
      // $(".panel-heading").click(function(){
      //   // sends the id (journey number) to mapLoad.load()
      //   load(this.id);
      // });
// $(function(){
//   $("#collapseOne").on('show.bs.collapse', function() {
//      Trigger map resize event  
//   load(1);

//   // run resize event
//   google.maps.event.trigger(map, 'resize');
// });



// });




</script>



</body>




</html>
