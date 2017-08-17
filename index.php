<?php
/**
 * User has successfully authenticated with Twitter. Access tokens saved to session and DB.
 */

/* Load required lib files. */
error_reporting(0);
require_once('oauth/twitteroauth.php');
require_once('config.php');
session_start();
class StripeAPI{
	protected  $consumer_key	 = 'ENTER CONSUMER KEY';
	protected  $consumer_secret	 = 'ENTER SECRET CONSUMER';
	protected  $oauth_callback	 = 'CALL BACK';
	
   function __construct() {

	 if(empty($_SESSION['status'])){		
		 $this->login_twitter();
		 }  
   }
	
function login_twitter(){
	if ($this->consumer_key === '' || $this->consumer_secret === '') {
  echo 'You need a consumer key and secret to test the sample code. Get one from <a href="https://twitter.com/apps">https://twitter.com/apps</a>';
 // exit;
}
/* Build an image link to start the redirect process. */

if(isset($_GET['connect']) && $_GET['connect']=='twitter'){
	
			$connection = new TwitterOAuth($this->consumer_key, $this->consumer_secret);// Key and Sec
			$request_token = $connection->getRequestToken($this->oauth_callback);// Retrieve Temporary credentials. 

			$_SESSION['oauth_token'] = $token = $request_token['oauth_token'];
			$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];


			switch ($connection->http_code) {
			  case 200:    $url = $connection->getAuthorizeURL($token); // Redirect to authorize page.
				header('Location: ' . $url); 
				break;
			  default:
				echo 'Could not connect to Twitter. Refresh the page or try again later.';
	}
		}	
	}
	
function twitter_callback(){
$connection = new TwitterOAuth($this->consumer_key, $this->consumer_secret, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
$access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);	
$_SESSION['access_token'] = $access_token;
unset($_SESSION['oauth_token']);
unset($_SESSION['oauth_token_secret']);

if (200 == $connection->http_code) {
  echo $_SESSION['status'] = 'verified';
   echo '<script type="text/javascript">
           window.location = "https://wwwmakemegeektk.000webhostapp.com/index.php?connected"
      </script>';
//header('Location: ./index.php?connected');
} else {
 header('Location: destroy.php?2');
}

}	
function  view(){
	if (empty($_SESSION['access_token']) || empty($_SESSION['access_token']['oauth_token']) || empty($_SESSION['access_token']['oauth_token_secret'])) {
    header('Location: ./destroy.php?3');
}
$access_token = $_SESSION['access_token'];

$connection = new TwitterOAuth($this->consumer_key, $this->consumer_secret, $access_token['oauth_token'], $access_token['oauth_token_secret']);

/* If method is set change API call made. Test is called by default. */
$content = $connection->get('account/verify_credentials');

//echo $content->name;echo $content->location;echo $content->followers_count;echo $content->friends_count;
//echo $content->friends_count;echo "<img src='{$content->profile_image_url}'/>";echo "<a href='./destroy.php'>LogOut</a>";
?>
<!DOCTYPE HTML>
<html>
<head>

        <link rel="stylesheet" href="w3.css">   
        <link rel="stylesheet" href="css/foundation.css" />
        <link rel="stylesheet" href="css/docs.css" /> 
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
	<style>
        #bgimg {
      background-position: center;
      background-repeat: no-repeat;
      background-size: cover;
      background-image: url('images/473471.jpg');
      height:100vh;
      }
        </style>
       <script type="text/javascript">
		$(document).ready(function(){
			$("#flip").click(function(){
		 		$("#divTweetContainer").slideToggle("slow");
		 	});
		 });
	</script>
</head>
<body>
<header id ="bgimg">
<div class="w3-display-bottomleft w3-container w3-blue w3-hide-small"
   style="bottom:83% ;opacity:0.7;width:70%">
 <h2>WELCOME<br><?php echo $content->name;?></h2>
</div>
<div class="w3-display-bottomleft  w3-container w3-blue w3-hover-orange w3-hide-small" style="bottom:63% ;opacity:0.7;width:30%">
     <a href="tweet.php?type=tweet&screenname=<?php echo $content->screen_name;?>"><h2>MY TWEETS</h2></a><br>
</div>
<div class="w3-display-bottomleft  w3-container w3-blue w3-hover-orange w3-hide-small" style="bottom:43% ;opacity:0.7;width:30%">
     <a href = "follower.php?type=tweet&screenname=<?php echo $content->screen_name;?>"><h2>MY FOLLOWERS</h2></a><br>
</div>
<div class="w3-display-bottomleft  w3-container w3-blue w3-hover-orange w3-hide-small" style="bottom:23% ;opacity:0.7;width:30%">
     <a href="googleSpreadSheet.php?type=tweet&screenname=<?php echo $content->screen_name;?>"><h2>DOWNLOAD TWEET</h2></a><br>
</div>
<div class="w3-display-bottomleft  w3-container w3-blue w3-hover-orange w3-hide-small" style="bottom:3% ;opacity:0.7;width:30%">
     <a href="Notice.php?type=tweet&screenname=<?php echo $content->screen_name;?>"><h2>NOTICE</h2></a><br>
</div>
</header>
      </body>
</html>
<?php

}
	}
global $twitter_obj;
if(isset($_REQUEST['connected']) && isset($_SESSION['status'])){
$twitter_obj = New StripeAPI();
$twitter_obj->view();
}else{
	$twitter_obj = New StripeAPI();
}