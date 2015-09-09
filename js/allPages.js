// Manages the loading of the sidebar
function sidebar(){
  // get sizes of header and spacers
  var mainHeaderHeight = $(".navbar-header").height();
  var twitterSpacerHeight = $("#sidebar-twitter-header").height();
  var facebookSpacerHeight = $("#sidebar-facebook-header").height();

  // calculate the size of each social widget
  var widgetHeight = (window.innerHeight-mainHeaderHeight-twitterSpacerHeight-facebookSpacerHeight)/2;

  // set the height of the twitter widget (minus padding)
  $("#twitter-holder").height(widgetHeight-20);
  $("#facebook-holder").height(widgetHeight-20);
  // get the sidebar width
  var facebookWidth = $("#sidebar-main").width();
  // removes padding
  facebookWidth -= 20;

  // apply width and height to facebook widget
  $('#facebook-holder').html(

    '<div class="fb-page" data-href="https://www.facebook.com/QUBEV?_rdr=p" data-width="'+facebookWidth+'" data-height="'+widgetHeight+'" data-small-header="true" data-adapt-container-width="false" data-hide-cover="true" data-show-facepile="false" data-show-posts="true"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/QUBEV?_rdr=p"><a href="https://www.facebook.com/QUBEV?_rdr=p">QUB Electric DeLorean</a></blockquote></div></div>'
  );

  FB.XFBML.parse( );
}

// resizes facebook widget on window resize
$(window).bind("resize", function(){  

  $('#facebook-holder').html(

  '<div class="fb-page" data-href="https://www.facebook.com/QUBEV?_rdr=p" data-width="" data-height="500" data-small-header="true" data-adapt-container-width="true" data-hide-cover="true" data-show-facepile="false" data-show-posts="true"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/QUBEV?_rdr=p"><a href="https://www.facebook.com/QUBEV?_rdr=p">QUB Electric DeLorean</a></blockquote></div></div>'
  );
  FB.XFBML.parse( );    

}); 

/*!
 * IE10 viewport hack for Surface/desktop Windows 8 bug
 * Copyright 2014-2015 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 */

// See the Getting Started docs for more information:
// http://getbootstrap.com/getting-started/#support-ie10-width

(function () {
  'use strict';

  if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
    var msViewportStyle = document.createElement('style');
    msViewportStyle.appendChild(
      document.createTextNode(
        '@-ms-viewport{width:auto!important}'
      )
    );
    document.querySelector('head').appendChild(msViewportStyle);
  }

})();

/*
* Gets XML data
*/
function downloadUrl(url, callback) {

      var request = window.ActiveXObject ?
      new ActiveXObject('Microsoft.XMLHTTP') :
      new XMLHttpRequest;

      request.onreadystatechange = function() {
        // ready state == 4 means complete
        if (request.readyState == 4) {
          request.onreadystatechange = doNothing;
          callback(request, request.status);
        }
      };
// Ajax request (GET request tyoe, url, true = asynchronous)
request.open('GET', url, true);
      // sends the Ajax request
      request.send(null);
    }

    function doNothing() {}
