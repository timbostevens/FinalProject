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
  <script type="text/javascript" src="charts/chartLoaderJour.js"></script>

    </head>
    
    <body onload="setupAccordion()">

  <!-- http://stackoverflow.com/questions/22037021/custom-facebook-share-button -->
    <!-- Load Facebook SDK for JavaScript -->
    <div id="fb-root"></div>
    <script>

    window.fbAsyncInit = function() {
        FB.init({
          appId      : '1053447491347132',
          xfbml      : true,
          version    : 'v2.4'
        });
      };
    (function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.4";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));




    function postToFeed(title, desc, url, image){
        var obj = {method: 'feed',link: url, picture: image, name: title,description: desc};
        function callback(response){}
        FB.ui(obj, callback);
      }



    </script>


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
                          <a id="panelLink1" data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                            <div class="row">
                              <div class="col-md-8">
                                <p class="accordion-title" id="journeyP1">Journey x</p>
                                <p id="dateP1">Date x</p>
                                <p id="startP1">Start x</p>
                                <p id="distanceP1">x miles</p>
                                <!-- Twitter button -->
                                <iframe id="tweet-button1" allowtransparency="true" frameborder="0" scrolling="no"
                                        src="http://platform.twitter.com/widgets/tweet_button.html?via=QUBDeLorean&amp;text=Replace%20Me&amp;count=horizontal"
                                        style="width:110px; height:20px;"></iframe>

                                <!-- NOT WORKING VERY WELL -->

                                <!-- facebook button -->
<!--                                 <div class="fb-share-button" 
                                    data-href="http://localhost/Project/FinalProject/journeys.php" 
                                    data-layout="button_count">
                                </div> -->

                                <!-- Facebook button -->
                                <!-- NEED TO REPLACE IMAGE NAME -->
                                <a id="facebook-button1" href="http://localhost/Project/FinalProject/journeys.php" data-image="http://localhost/Project/FinalProject/img/qubev.png" data-title="The Electric Delorean Rides Again!" data-desc="Some description k jh for this article" class="btnShare"><img src="img/FB-f-Logo__blue_58.png" alt="share" style="width:25px;height:25px;"></a>
                              
                              </div>
                              <div class="col-md-4">
                                <img src="img/sampleMap02.jpg" id="panel-static-image1"/>
                              </div>
                            </a>
                          </h4>
                        </div>
                        <!-- Main Panel Body -->
                        <!-- id set as journey number (used lated when clicked to load map) -->
                        <div id="collapse1" class="panel-collapse collapse">
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
                              <!-- spacer -->
                                    <div style="width: 100%; height:30px;"></div>


                            <div class="row">
                              <!-- Left hand column containing stat list -->

                        <!-- MIGHT WANT TO DO THIS AS A LIST OF BUTTONS
                        THIS WILL PRE-SET HIGHLIGHTING OF CURRENT CHOICE -->
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
                      <div class="panel-heading">
                        <h4 class="panel-title">
                          <!-- href set as journey number -->
                          <a id="panelLink2" data-toggle="collapse" data-parent="#accordion" href="#collapse2">
                            <div class="row">
                              <div class="col-md-8">
                                <p class="accordion-title" id="journeyP2">Journey x</p>
                                <p id="dateP2">Date x</p>
                                <p id="startP2">Start x</p>
                                <p id="distanceP2">x miles</p>
                                <!-- Twitter button -->
                                <iframe id="tweet-button2" allowtransparency="true" frameborder="0" scrolling="no"
                                        src="http://platform.twitter.com/widgets/tweet_button.html?via=QUBDeLorean&amp;text=Replace%20Me&amp;count=horizontal"
                                        style="width:110px; height:20px;"></iframe>

                                <!-- Facebook button -->
                                <!-- NEED TO REPLACE IMAGE NAME -->
                                <a id="facebook-button2" href="http://localhost/Project/FinalProject/journeys.php" data-image="http://localhost/Project/FinalProject/img/qubev.png" data-title="The Electric Delorean Rides Again!" data-desc="Some description k jh for this article" class="btnShare"><img src="img/FB-f-Logo__blue_58.png" alt="share" style="width:25px;height:25px;"></a>




                              </div>
                              <div class="col-md-4">
                                <img src="img/sampleMap02.jpg" id="panel-static-image2"/>
                              </div>
                            </a>
                          </h4>
                        </div>
                        <!-- Main Panel Body -->
                        <!-- id set as journey number (used lated when clicked to load map) -->
                        <div id="collapse2" class="panel-collapse collapse">
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
                        <div class="col-md-4 box">
                          
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
                          </div> <!-- end second accordion -->


                          <!-- This is the third accordion entry -->
                    <div class="panel panel-default accordion-panel" id="panel3">
                      <!-- Panel Header -->
                      <div class="panel-heading">
                        <h4 class="panel-title">
                          <!-- href set as journey number -->
                          <a id="panelLink3" data-toggle="collapse" data-parent="#accordion" href="#collapse3">
                            <div class="row">
                              <div class="col-md-8">
                                <p class="accordion-title" id="journeyP3">Journey x</p>
                                <p id="dateP3">Date x</p>
                                <p id="startP3">Start x</p>
                                <p id="distanceP3">x miles</p>
                                <!-- Twitter button -->
                                <iframe id="tweet-button3" allowtransparency="true" frameborder="0" scrolling="no"
                                        src="http://platform.twitter.com/widgets/tweet_button.html?via=QUBDeLorean&amp;text=Replace%20Me&amp;count=horizontal"
                                        style="width:110px; height:20px;"></iframe>

                                <!-- Facebook button -->
                                <!-- NEED TO REPLACE IMAGE NAME -->
                                <a id="facebook-button3" href="http://localhost/Project/FinalProject/journeys.php" data-image="http://localhost/Project/FinalProject/img/qubev.png" data-title="The Electric Delorean Rides Again!" data-desc="Some description k jh for this article" class="btnShare"><img src="img/FB-f-Logo__blue_58.png" alt="share" style="width:25px;height:25px;"></a>



                              </div>
                              <div class="col-md-4">
                                <img src="img/sampleMap02.jpg" id="panel-static-image3"/>
                              </div>
                            </a>
                          </h4>
                        </div>
                        <!-- Main Panel Body -->
                        <!-- id set as journey number (used lated when clicked to load map) -->
                        <div id="collapse3" class="panel-collapse collapse">
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
                        <div class="col-md-4 box">
                          
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
                      <div class="panel-heading">
                        <h4 class="panel-title">
                          <!-- href set as journey number -->
                          <a id="panelLink4" data-toggle="collapse" data-parent="#accordion" href="#collapse4">
                            <div class="row">
                              <div class="col-md-8">
                                <p class="accordion-title" id="journeyP4">Journey x</p>
                                <p id="dateP4">Date x</p>
                                <p id="startP4">Start x</p>
                                <p id="distanceP4">x miles</p>
                                <!-- Twitter button -->
                                <iframe id="tweet-button4" allowtransparency="true" frameborder="0" scrolling="no"
                                        src="http://platform.twitter.com/widgets/tweet_button.html?via=QUBDeLorean&amp;text=Replace%20Me&amp;count=horizontal"
                                        style="width:110px; height:20px;"></iframe>

                                <!-- Facebook button -->
                                <!-- NEED TO REPLACE IMAGE NAME -->
                                <a id="facebook-button4" href="http://localhost/Project/FinalProject/journeys.php" data-image="http://localhost/Project/FinalProject/img/qubev.png" data-title="The Electric Delorean Rides Again!" data-desc="Some description k jh for this article" class="btnShare"><img src="img/FB-f-Logo__blue_58.png" alt="share" style="width:25px;height:25px;"></a>

                              </div>
                              <div class="col-md-4">
                                <img src="img/sampleMap02.jpg" id="panel-static-image4"/>
                              </div>
                            </a>
                          </h4>
                        </div>
                        <!-- Main Panel Body -->
                        <!-- id set as journey number (used lated when clicked to load map) -->
                        <div id="collapse4" class="panel-collapse collapse">
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
                        <div class="col-md-4 box">
                          

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
                      <div class="panel-heading">
                        <h4 class="panel-title">
                          <!-- href set as journey number -->
                          <a id="panelLink5" data-toggle="collapse" data-parent="#accordion" href="#collapse5">
                            <div class="row">
                              <div class="col-md-8">
                                <p class="accordion-title" id="journeyP5">Journey x</p>
                                <p id="dateP5">Date x</p>
                                <p id="startP5">Start x</p>
                                <p id="distanceP5">x miles</p>
                                <!-- Twitter button -->
                                <iframe id="tweet-button5" allowtransparency="true" frameborder="0" scrolling="no"
                                        src="http://platform.twitter.com/widgets/tweet_button.html?via=QUBDeLorean&amp;text=Replace%20Me&amp;count=horizontal"
                                        style= "width:110px; height:20px;"></iframe>

                                <!-- Facebook button -->
                                <!-- NEED TO REPLACE IMAGE NAME -->
                                <a id="facebook-button5" href="http://localhost/Project/FinalProject/journeys.php" data-image="http://localhost/Project/FinalProject/img/qubev.png" data-title="The Electric Delorean Rides Again!" data-desc="Some description k jh for this article" class="btnShare"><img src="img/FB-f-Logo__blue_58.png" alt="share" style="width:25px;height:25px;"></a>



                              </div>
                              <div class="col-md-4">
                                <img src="img/sampleMap02.jpg" id="panel-static-image5"/>
                              </div>
                            </a>
                          </h4>
                        </div>
                        <!-- Main Panel Body -->
                        <!-- id set as journey number (used lated when clicked to load map) -->
                        <div id="collapse5" class="panel-collapse collapse">
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
                        <div class="col-md-4 box">
                          

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
        <!-- Data loading code -->
    <script type="text/javascript" src="charts/journeyColumnChartLoad.js"></script>
        <!-- Accordion Manager -->
    <script type="text/javascript" src="accordionManager.js"></script>
        <!-- Endless Scroll Manager-->
    <script type="text/javascript" src="endlessScroll.js"></script>


    <!-- Checks for scrolling to the bottom of the page then calls addNewPanels() from endlessScroll.js -->
    <script>
    $(window).scroll(function() {
      if($(window).scrollTop() == $(document).height() - $(window).height()) {
           addNewPanels();
      }
    });
    </script>

    <script type="text/javascript">


          $(document).on('click', '.btnShare',function(){

          elem = $(this);
          postToFeed(elem.data('title'), elem.data('desc'), elem.prop('href'), elem.data('image'));

          return false;
          });



    </script>


</body>




</html>
