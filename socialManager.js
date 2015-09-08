          function sidebar(){
          // get sizes of header and spacers
          var mainHeaderHeight = $("#navbar-header").height();
          var twitterSpacerHeight = $("#twitter-holder").height();
          var facebookSpacerHeight = $("#facebook-holder").height();

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