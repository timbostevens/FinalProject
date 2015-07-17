<?php

session_start();

require "twitteroauth/autoload.php";

use Abraham\TwitterOAuth\TwitterOAuth;

include("twitteroauth/src/twitteroauth.php");

$apikey="UHmZUGBPOKe1At9ps8aD97w0k";
$apisecret="UHmZUGBPOKe1At9ps8aD97w0k";
$accesstoken="2826944840-vhBWfo3vdsLtCrZDN0ux6h88XQmRBl9DvhoBIYx";
$accesssecret="Ic9qVARSAAJFLLnVq8DlNGF6TxuHIRQZa30NFCwM79kml";

$connection = new TwitterOAuth($apikey, $apisecret, $accesstoken, $accesssecret);

$content = $connection->get("account/verify_credentials");


$tweets = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=twitterapi&count=2");

print_r($content);

?>