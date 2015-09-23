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

 <body>



     <!--Div that will hold the scatterchart dashboard-->
     <div id="dashboard_div" class="vis-chart-container-beside">

         <div id="scatter_div" style="height: 500px; width: 100%"></div>

<!--          <div class="btn-group chart-button">
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
         </div> -->

<!--          <div class="btn-group chart-button">
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
     </div> -->


     <!-- CURRENTLY HIDING ALL FILTERS -->

     <!--Divs that will hold each control and chart-->
     <div id="speed_filter_div" style="display:none"></div>
     <div id="distance_filter_div" style="display:none"></div>
     <div id="duration_filter_div" style="display:none"></div>
     <div id="petrol_filter_div" style="display:none"></div>
     <div id="co2_filter_div" style="display:none"></div>
 </div>


<!--Load the Google Charts AJAX API -->
<script type="text/javascript" src="https://www.google.com/jsapi"></script>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- twitter widget -->
    <script src="https://platform.twitter.com/widgets.js"></script>
    <!-- Script to size facebook and twitter widgets also contains ie10 workaround-->
    <script src="js/allPages.js" type="text/javascript"></script>
    <!-- Load heatmap api -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=visualization&sensor=true_or_false"></script>
    <!-- Code for all charts -->
    <script type="text/javascript" src="js/visScatterTest.js"></script>


</body>




</html>
