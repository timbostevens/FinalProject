// Facebook setup
window.fbAsyncInit = function() {
        FB.init({
          appId      : '1053447491347132',
          xfbml      : true,
          version    : 'v2.4'
        });
      };

// facebook setup
(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.4";
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));


// Facebook method to post to feed
function postToFeed(title, desc, url, image){
    var obj = {method: 'feed',link: url, picture: image, name: title, description: desc};
    function callback(response){}
    FB.ui(obj, callback);
  }


// Twitter setup
!function(d,s,id){                    
var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");