<!-- If there is a GET variable get it -->
<?php
  $requiredJourney =  filter_input(INPUT_GET,'journey');

  // checks if the journey received is all digits (ie a number with no decimals) and isn't empty
  if ((!ctype_digit($requiredJourney)) && (!$requiredJourney=="")) {
    // if not all digits then the request was invalid
    // change to an invalid number that the code will recognise as such
    $requiredJourney = 0;
  } 

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Download fint from google -->
  <link href='http://fonts.googleapis.com/css?family=Biryani' rel='stylesheet' type='text/css'>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <meta name="description" content="QUB Electic DeLorean Project - Journey Data">
  <meta name="author" content="">
  <meta name="keywords" content="Electric, DeLorean, Car, QUB, Queen's University Belfast, Journey, Data, Map, Chart, Graph">
  <link rel="icon" href="img/qubev.ico">

  <title>QUBEV</title>

  <!-- Bootstrap core CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/styles.css" rel="stylesheet">

    <!-- Custom Fonts for symbols-->
  <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

</head>
    
<body onload="sidebar(); setupAccordion(<?php echo $requiredJourney; ?>)">

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
                <a class="navbar-brand" href="index.html">QUBEV</a>

                <a class = "nav-social" href="https://twitter.com/intent/follow?screen_name=QUBDeLorean"><img src="img/twitter_white_nav.png" /></a>

                <a class = "nav-social" href="https://www.facebook.com/QUBEV"><img src="img/facebook_white_nav.png" /></a>
              
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
            <div class="jumbotron" id="middle">
              <div class="container">
         
                <!-- set up accordion list -->
                  <div class="panel-group" id="accordion">
                   

                    <!-- This is the first accordion entry -->
                    <div class="panel panel-default accordion-panel" id="panel1">
                      <!-- Panel Header -->
                      <div class="panel-heading" id="panel-heading1">
                        <h4 class="panel-title">
                          <!-- href set as panel number -->
                          <a id="panelLink1" data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                            <div class="row">
                            

                              <div class="col-md-2 hidden-xs hidden-sm panel-title-expand">
                                <div id="expand-icon1" class="fa fa-angle-right fa-2x expand-symbol"></div>
                              </div>
                            

                              <div class="col-md-7 panel-title-text">
                                <p class="accordion-title" id="journeyP1">Journey x</p>
                                <p id="dateP1">Date x</p>
                                <p id="startP1">Start x</p>
                                <p id="distanceP1">x miles</p>
                              </div>


                              <div class="col-md-3 panel-title-map">
                                <img src="img/sampleMap02.jpg" id="panel-static-image1"/>
                              </div>
                            </div> <!-- end row -->

                            </a>
                          </h4>
                        </div>
                        <!-- Main Panel Body -->
                        <!-- id set as journey number (used lated when clicked to load map) -->
                        <div id="collapse1" class="panel-collapse collapse">
                          <div class="panel-body">
                              <div class = "journey-social-holder">

                                <!-- Facebook button -->
                                <!-- NEED TO REPLACE IMAGE NAME -->
                                <a id="facebook-button1" style="float: right" href="http://localhost/Project/FinalProject/journeys.php" data-image="http://localhost/Project/FinalProject/img/qubev.png" data-title="The Electric DeLorean Rides Again!" data-desc="Some description k jh for this article" class="btnShare"><img src="img/FB-f-Logo__blue_58.png" alt="share" style="width:20px;height:20px;"></a>

                                <!-- Twitter button -->
                                <iframe id="tweet-button1" allowtransparency="true" frameborder="0" scrolling="no"
                                        src="http://platform.twitter.com/widgets/tweet_button.html?via=QUBDeLorean&amp;text=Replace%20Me&amp;count=none"
                                        style="width:70px; height:20px; float: right"></iframe>


                                <p>share this journey</p>

                              </div>
                              

                            <div class = "googlemap">
                              <div id="mapcanvas1" style="width: 100%; height: 300px;"></div>
                            </div>
    
                                      <!-- large horizontal chart -->
                                    <div id="journey-area-chart1" style="width: 100%; height: 300px"></div>

                              <!-- spacer -->
                                    <div style="width: 100%; height:30px;"></div>

                            <div class="row">
                              <!-- Left hand column containing stat list -->
                        <div class="col-md-4 box">
                          
                              <!-- spacer -->
                          <div style="width: 100%; height:30px;"></div>

                          <p>Start Time: <span id="start-stat1">xxxxxx</span></p>
                          <p>End Time: <span id="end-stat1">xxxxxx</span></p>
                          <p> Distance: <span id="distance-stat1">xxxxxx</span> miles</p>
                          <p>Duration: <span id="duration-stat1">xxxxxx</span> minutes</p>
                          <p>Speed: <span id="speed-stat1">xxxxxx</span> mph</p>
                          <p>Petrol Saved: <span id="petrol-stat1">xxxxxx</span> L</p>
                          <p>CO2 Saved: <span id="co2-stat1">xxxxxxx</span> kg</p>


                          </div> <!-- end col-md-6 -->
                                  <!-- Right hand column containing chart -->
                            <div class="col-md-8 box">
                              
                              <div id="journey-column-chart1" style="width: 100%; height: 300px"></div>

                            </div> <!-- end col-md-6 box-->

                          </div> <!-- end row -->

                              </div> <!-- end panel body -->
                            </div> <!-- end main panel body -->
                          </div> <!-- end first accordion -->

                          <!-- This is the second accordion entry -->
                    <div class="panel panel-default accordion-panel" id="panel2">
                      <!-- Panel Header -->
                      <div class="panel-heading" id="panel-heading2">
                        <h4 class="panel-title">
                          <!-- href set as panel number -->
                          <a id="panelLink2" data-toggle="collapse" data-parent="#accordion" href="#collapse2">
                            <div class="row">                            

                              <div class="col-md-2 hidden-xs hidden-sm panel-title-expand">
                                <div id="expand-icon2" class="fa fa-angle-right fa-2x expand-symbol"></div>
                              </div>

                              <div class="col-md-7 panel-title-text">
                                <p class="accordion-title" id="journeyP2">Journey x</p>
                                <p id="dateP2">Date x</p>
                                <p id="startP2">Start x</p>
                                <p id="distanceP2">x miles</p>
                              </div>

                              <div class="col-md-3 panel-title-map">
                                <img src="img/sampleMap02.jpg" id="panel-static-image2"/>
                              </div>
                            </div> <!-- end row -->

                            </a>
                          </h4>
                        </div>
                        <!-- Main Panel Body -->
                        <!-- id set as journey number (used lated when clicked to load map) -->
                        <div id="collapse2" class="panel-collapse collapse">
                          <div class="panel-body">
                              <div class = "journey-social-holder">

                                <!-- Facebook button -->
                                <!-- NEED TO REPLACE IMAGE NAME -->
                                <a id="facebook-button2" style="float: right" href="http://localhost/Project/FinalProject/journeys.php" data-image="http://localhost/Project/FinalProject/img/qubev.png" data-title="The Electric DeLorean Rides Again!" data-desc="Some description k jh for this article" class="btnShare"><img src="img/FB-f-Logo__blue_58.png" alt="share" style="width:20px;height:20px;"></a>

                                <!-- Twitter button -->
                                <iframe id="tweet-button2" allowtransparency="true" frameborder="0" scrolling="no"
                                        src="http://platform.twitter.com/widgets/tweet_button.html?via=QUBDeLorean&amp;text=Replace%20Me&amp;count=none"
                                        style="width:70px; height:20px; float: right"></iframe>

                                <p style="float: right">share this journey</p>

                              </div>
                              

                            <div class = "googlemap">
                              <div id="mapcanvas2" style="width: 100%; height: 300px;"></div>
                            </div>

                                  <!-- large horizontal chart -->
                                    <div id="journey-area-chart2" style="width: 100%; height: 300px"></div>

                              <!-- spacer -->
                                    <div style="width: 100%; height:30px;"></div>


                            <div class="row">
                              <!-- Left hand column containing stat list -->
                        <div class="col-md-4 box">
                          
                              <!-- spacer -->
                          <div style="width: 100%; height:30px;"></div>

                          <p>Start Time: <span id="start-stat2">xxxxxx</span></p>
                          <p>End Time: <span id="end-stat2">xxxxxx</span></p>
                          <p> Distance: <span id="distance-stat2">xxxxxx</span> miles</p>
                          <p>Duration: <span id="duration-stat2">xxxxxx</span> minutes</p>
                          <p>Speed: <span id="speed-stat2">xxxxxx</span> mph</p>
                          <p>Petrol Saved: <span id="petrol-stat2">xxxxxx</span> L</p>
                          <p>CO2 Saved: <span id="co2-stat2">xxxxxxx</span> kg</p>

                          </div> <!-- end col-md-6 -->
                                  <!-- Right hand column containing chart -->
                            <div class="col-md-8 box">
                              
                              <div id="journey-column-chart2" style="width: 100%; height: 300px"></div>

                            </div> <!-- end col-md-6 box-->

                          </div> <!-- end row -->

                              </div> <!-- end panel body -->
                            </div> <!-- end main panel body -->
                          </div><!-- end second accordion -->


                          <!-- This is the third accordion entry -->
                    <div class="panel panel-default accordion-panel" id="panel3">
                      <!-- Panel Header -->
                      <div class="panel-heading" id="panel-heading3">
                        <h4 class="panel-title">
                          <!-- href set as panel number -->
                          <a id="panelLink3" data-toggle="collapse" data-parent="#accordion" href="#collapse3">
                            <div class="row">

                              <div class="col-md-2 hidden-xs hidden-sm panel-title-expand">
                                <div id="expand-icon3" class="fa fa-angle-right fa-2x expand-symbol"></div>
                              </div>
                            
                              <div class="col-md-7 panel-title-text">
                                <p class="accordion-title" id="journeyP3">Journey x</p>
                                <p id="dateP3">Date x</p>
                                <p id="startP3">Start x</p>
                                <p id="distanceP3">x miles</p>
                              </div>

                              <div class="col-md-3 panel-title-map">
                                <img src="img/sampleMap02.jpg" id="panel-static-image3"/>
                              </div>
                            </div> <!-- end row -->

                            </a>
                          </h4>
                        </div>
                        <!-- Main Panel Body -->
                        <!-- id set as journey number (used lated when clicked to load map) -->
                        <div id="collapse3" class="panel-collapse collapse">
                          <div class="panel-body">
                              <div class = "journey-social-holder">

                                <!-- Facebook button -->
                                <!-- NEED TO REPLACE IMAGE NAME -->
                                <a id="facebook-button3" style="float: right" href="http://localhost/Project/FinalProject/journeys.php" data-image="http://localhost/Project/FinalProject/img/qubev.png" data-title="The Electric DeLorean Rides Again!" data-desc="Some description k jh for this article" class="btnShare"><img src="img/FB-f-Logo__blue_58.png" alt="share" style="width:20px;height:20px;"></a>

                                <!-- Twitter button -->
                                <iframe id="tweet-button3" allowtransparency="true" frameborder="0" scrolling="no"
                                        src="http://platform.twitter.com/widgets/tweet_button.html?via=QUBDeLorean&amp;text=Replace%20Me&amp;count=none"
                                        style="width:70px; height:20px; float: right"></iframe>

                                <p style="float: right">share this journey</p>

                              </div>

                            <div class = "googlemap">
                              <div id="mapcanvas3" style="width: 100%; height: 300px;"></div>
                            </div>

                                  <!-- large horizontal chart -->
                                    <div id="journey-area-chart3" style="width: 100%; height: 300px"></div>

                              <!-- spacer -->
                                    <div style="width: 100%; height:30px;"></div>

                            <div class="row">
                        <!-- Left hand column containing stat list -->
                        <div class="col-md-4 box">
                          
                              <!-- spacer -->
                          <div style="width: 100%; height:30px;"></div>

                          <p>Start Time: <span id="start-stat3">xxxxxx</span></p>
                          <p>End Time: <span id="end-stat3">xxxxxx</span></p>
                          <p> Distance: <span id="distance-stat3">xxxxxx</span> miles</p>
                          <p>Duration: <span id="duration-stat3">xxxxxx</span> minutes</p>
                          <p>Speed: <span id="speed-stat3">xxxxxx</span> mph</p>
                          <p>Petrol Saved: <span id="petrol-stat3">xxxxxx</span> L</p>
                          <p>CO2 Saved: <span id="co2-stat3">xxxxxxx</span> kg</p>


                          </div> <!-- end col-md-6 -->
                                  <!-- Right hand column containing chart -->
                            <div class="col-md-8 box">
                              
                              <div id="journey-column-chart3" style="width: 100%; height: 300px"></div>

                            </div> <!-- end col-md-6 box-->

                          </div> <!-- end row -->

                              </div> <!-- end panel body -->
                            </div> <!-- end main panel body -->
                          </div> <!-- end third accordion -->

                          <!-- This is the fourth accordion entry -->
                  <div class="panel panel-default accordion-panel" id="panel4">
                      <!-- Panel Header -->
                      <div class="panel-heading" id="panel-heading4">
                        <h4 class="panel-title">
                          <!-- href set as panel number -->
                          <a id="panelLink4" data-toggle="collapse" data-parent="#accordion" href="#collapse4">
                            <div class="row">
                            
                              <div class="col-md-2 hidden-xs hidden-sm panel-title-expand">
                                <div id="expand-icon4" class="fa fa-angle-right fa-2x expand-symbol"></div>
                              </div>
                            
                              <div class="col-md-7 panel-title-text">
                                <p class="accordion-title" id="journeyP4">Journey x</p>
                                <p id="dateP4">Date x</p>
                                <p id="startP4">Start x</p>
                                <p id="distanceP4">x miles</p>
                              </div>

                              <div class="col-md-3 panel-title-map">
                                <img src="img/sampleMap02.jpg" id="panel-static-image4"/>
                              </div>
                            </div> <!-- end row -->

                            </a>
                          </h4>
                        </div>
                        <!-- Main Panel Body -->
                        <!-- id set as journey number (used lated when clicked to load map) -->
                        <div id="collapse4" class="panel-collapse collapse">
                          <div class="panel-body">
                              <div class = "journey-social-holder">

                                <!-- Facebook button -->
                                <!-- NEED TO REPLACE IMAGE NAME -->
                                <a id="facebook-button4" style="float: right" href="http://localhost/Project/FinalProject/journeys.php" data-image="http://localhost/Project/FinalProject/img/qubev.png" data-title="The Electric DeLorean Rides Again!" data-desc="Some description k jh for this article" class="btnShare"><img src="img/FB-f-Logo__blue_58.png" alt="share" style="width:20px;height:20px;"></a>

                                <!-- Twitter button -->
                                <iframe id="tweet-button4" allowtransparency="true" frameborder="0" scrolling="no"
                                        src="http://platform.twitter.com/widgets/tweet_button.html?via=QUBDeLorean&amp;text=Replace%20Me&amp;count=none"
                                        style="width:70px; height:20px; float: right"></iframe>

                                <p style="float: right">share this journey</p>

                              </div>
                              
                            <div class = "googlemap">
                              <div id="mapcanvas4" style="width: 100%; height: 300px;"></div>
                            </div>
                          
                                  <!-- large horizontal chart -->
                                    <div id="journey-area-chart4" style="width: 100%; height: 300px"></div>
                              <!-- spacer -->
                                    <div style="width: 100%; height:30px;"></div>

                            <div class="row">
                              <!-- Left hand column containing stat list -->

                        <div class="col-md-4 box">
                          
                              <!-- spacer -->
                          <div style="width: 100%; height:30px;"></div>

                          <p>Start Time: <span id="start-stat4">xxxxxx</span></p>
                          <p>End Time: <span id="end-stat4">xxxxxx</span></p>
                          <p> Distance: <span id="distance-stat4">xxxxxx</span> miles</p>
                          <p>Duration: <span id="duration-stat4">xxxxxx</span> minutes</p>
                          <p>Speed: <span id="speed-stat4">xxxxxx</span> mph</p>
                          <p>Petrol Saved: <span id="petrol-stat4">xxxxxx</span> L</p>
                          <p>CO2 Saved: <span id="co2-stat4">xxxxxxx</span> kg</p>

                          </div> <!-- end col-md-6 -->
                                  <!-- Right hand column containing chart -->
                            <div class="col-md-8 box">
                              
                              <div id="journey-column-chart4" style="width: 100%; height: 300px"></div>

                            </div> <!-- end col-md-6 box-->

                          </div> <!-- end row -->

                              </div> <!-- end panel body -->
                            </div> <!-- end main panel body -->
                          </div> <!-- end fourth accordion -->

                          <!-- This is the fifth accordion entry -->
                    <div class="panel panel-default accordion-panel" id="panel5">
                      <!-- Panel Header -->
                      <div class="panel-heading" id="panel-heading5">
                        <h4 class="panel-title">
                          <!-- href set as panel number -->
                          <a id="panelLink5" data-toggle="collapse" data-parent="#accordion" href="#collapse5">
                            <div class="row">
                            
                              <div class="col-md-2 hidden-xs hidden-sm panel-title-expand">
                                <div id="expand-icon5" class="fa fa-angle-right fa-2x expand-symbol"></div>
                              </div>
                            
                              <div class="col-md-7 panel-title-text">
                                <p class="accordion-title" id="journeyP5">Journey x</p>
                                <p id="dateP5">Date x</p>
                                <p id="startP5">Start x</p>
                                <p id="distanceP5">x miles</p>
                              </div>

                              <div class="col-md-3 panel-title-map">
                                <img src="img/sampleMap02.jpg" id="panel-static-image5"/>
                              </div>
                            </div> <!-- end row -->

                            </a>
                          </h4>
                        </div>
                        <!-- Main Panel Body -->
                        <!-- id set as journey number (used lated when clicked to load map) -->
                        <div id="collapse5" class="panel-collapse collapse">
                          <div class="panel-body">
                              <div class = "journey-social-holder">
                                <!-- <p style="float: left">Share this journey:</p> -->

                                <!-- Facebook button -->
                                <!-- NEED TO REPLACE IMAGE NAME -->
                                <a id="facebook-button5" style="float: right" href="http://localhost/Project/FinalProject/journeys.php" data-image="http://localhost/Project/FinalProject/img/qubev.png" data-title="The Electric DeLorean Rides Again!" data-desc="Some description k jh for this article" class="btnShare"><img src="img/FB-f-Logo__blue_58.png" alt="share" style="width:20px;height:20px;"></a>

                                <!-- Twitter button -->
                                <iframe id="tweet-button5" allowtransparency="true" frameborder="0" scrolling="no"
                                        src="http://platform.twitter.com/widgets/tweet_button.html?via=QUBDeLorean&amp;text=Replace%20Me&amp;count=none"
                                        style="width:70px; height:20px; float: right"></iframe>

                                <p style="float: right">share this journey</p>

                              </div>
                              
                            <div class = "googlemap">
                              <div id="mapcanvas5" style="width: 100%; height: 300px;"></div>
                            </div>
                          
                            <!-- <div class="row"> -->
                                <!-- <div class="col-md-12"> -->
                                  <!-- large horizontal chart -->
                                    <div id="journey-area-chart5" style="width: 100%; height: 300px"></div>

                                <!-- </div> -->
                            <!-- </div> -->
                              <!-- spacer -->
                                    <div style="width: 100%; height:30px;"></div>

                            <div class="row">
                              <!-- Left hand column containing stat list -->

                        <!-- MIGHT WANT TO DO THIS AS A LIST OF BUTTONS
                        THIS WILL PRE-SET HIGHLIGHTING OF CURRENT CHOICE -->
                        <div class="col-md-4 box">
                          
                              <!-- spacer -->
                          <div style="width: 100%; height:30px;"></div>

                          <p>Start Time: <span id="start-stat5">xxxxxx</span></p>
                          <p>End Time: <span id="end-stat5">xxxxxx</span></p>
                          <p> Distance: <span id="distance-stat5">xxxxxx</span> miles</p>
                          <p>Duration: <span id="duration-stat5">xxxxxx</span> minutes</p>
                          <p>Speed: <span id="speed-stat5">xxxxxx</span> mph</p>
                          <p>Petrol Saved: <span id="petrol-stat5">xxxxxx</span> L</p>
                          <p>CO2 Saved: <span id="co2-stat5">xxxxxxx</span> kg</p>


                          </div> <!-- end col-md-6 -->
                                  <!-- Right hand column containing chart -->
                            <div class="col-md-8 box">
                              
                              <div id="journey-column-chart5" style="width: 100%; height: 300px"></div>

                            </div> <!-- end col-md-6 box-->

                          </div> <!-- end row -->

                              </div> <!-- end panel body -->
                            </div> <!-- end main panel body -->
                          </div> <!-- end fifth accordion -->

                        </div> <!-- end panel group id=accordion -->
                    </div> <!-- end container -->
                  </div> <!-- end Jumbotron -->


                  <img src="img/loading.GIF" id="loading-spinner"/>

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
    <!-- Load core chart scrip-->
    <!-- <script type="text/javascript" src="jsJour/chartLoaderJour.js"></script> -->
    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <!-- <script src="js/ie10-viewport-bug-workaround.js"></script> -->
    <!-- twitter widget -->
    <script src="https://platform.twitter.com/widgets.js"></script>
    <!-- Script to size facebook and twitter widgets also contains ie10 workaround-->
    <script type="text/javascript" src="js/allPages.js"></script>
    <!-- Load Google map API -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>
    <!-- Code for Ajax Helper -->
    <!-- <script type="text/javascript" src="ajaxHelper.js"></script> -->
    <!-- Data loading code -->
    <!-- <script type="text/javascript" src="journeyDataLoad.js"></script> -->
        <!-- Data loading code -->
    <!-- <script type="text/javascript" src="jsJour/journeyColumnChartLoad.js"></script> -->
        <!-- Accordion Manager -->
    <!-- <script type="text/javascript" src="accordionManager.js"></script> -->
        <script type="text/javascript" src="jsJour/journeyScript.js"></script>


    <!-- Script to manage facebook share click -->
    <!-- Can't seem to move it to external file -->
    <script type="text/javascript">
          $(document).on('click', '.btnShare',function(){
          elem = $(this);
          postToFeed(elem.data('title'), elem.data('desc'), elem.prop('href'), elem.data('image'));
          return false;
          });
    </script>



</body>




</html>
