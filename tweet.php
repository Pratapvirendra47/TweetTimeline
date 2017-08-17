<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="w3.css">   
<link rel="stylesheet" href="css/foundation.css" />
<link rel="stylesheet" href="css/docs.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" type="text/css" href="style2.css">
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#flip").click(function(){
		 		$("#divTweetContainer").slideToggle("slow");
		 	});
		 });
	</script>
</head>

</html>
<?php
	error_reporting(0);
	require_once('oauth/twitteroauth.php');

	if($_GET['type']=='follower'){
			getTweets2($_GET['screenname'],$_GET['type']);
	}
       else if($_GET['type']=='tweet'){
			getTweets($_GET['screenname'],$_GET['type']);
	}
	function getConnectionwithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret){

		$connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
  		return $connection;
	}

	function getTweets($sname,$type)
	{
		$notweets = 10;
		$consumerkey = 'ENTER CONSUMER';
		$consumersecret = 'ENTER SECRET';
		$access_token = $_SESSION['access_token'];
          
		
		$connection = getConnectionWithAccessToken($consumerkey,$consumersecret, $access_token['oauth_token'], $access_token['oauth_token_secret']);


		$tweeturl = $connection->get("https://api.twitter.com/1.1/statuses/home_timeline.json?screen_name=".$sname."&count=".$notweets);
               
 		$obj = json_decode(json_encode($tweeturl));		
		
                echo"<div class='w3-container'>";
                echo "<h3 class='w3-text-teal'>Tweets of <b>$sname</b></h3>";
                echo"</div>";
                $div=1;
                foreach ($obj as $item)
		{
			$text = $item->text;
			$timestamp = $item->created_at;	
			
			if($type == 'tweet')
			{
				echo "<div id='divTweet$divno'>";
			}
			if($type =='follower')
			{
				echo "<div id='divFollo$divno'>";
			}
			echo "<div id='flip'>CLICK</div>";
   
            echo"<div id='divTweetContainer'>"
            echo "<div class='w3-margin w3-panel w3-border-left w3-leftbar w3-pale-blue w3-border-blue'>";
			echo "<p class='w3-container'>Tweet $divno of 10</p>";
			print "<p class='w3-container'>".$text."</p>"."<p class='w3-container'>Tweeted on: </p>"."<p class='w3-container'>".str_replace("+0000","",$timestamp,$replacecount)."</p>";
			echo "</div>";
                        echo "<br>";
             echo"</div>";
			$divno = $divno + 1;
		}
	}
	function getTweets2($sname,$type)
	{
		$notweets = 10;
		$consumerkey = 'ENTER CONSUMER';
		$consumersecret = 'ENTER SECRET';
		$access_token = $_SESSION['access_token'];
$connection = getConnectionWithAccessToken($consumerkey,$consumersecret, $access_token['oauth_token'], $access_token['oauth_token_secret']);


		$tweeturl = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$sname."&count=".$notweets);
 		$obj = json_decode(json_encode($tweeturl));		
		 echo"<div class='w3-container'>";
                echo "<h3 class='w3-text-teal'>Tweets of <b>$sname</b></h3>";
                echo"</div>";
                foreach ($obj as $item)
		{
			$text = $item->text;
			$timestamp = $item->created_at;	
			
			if($type == 'tweet')
			{
				echo "<div id='divTweet$divno'>";
			}
			if($type =='follower')
			{
				echo "<div id='divFollo$divno'>";
			}


			echo "<div id='flip'>CLICK</div>";

			echo "<div id=''divTweetContainer''></div>";

			echo "<div class='w3-margin w3-panel w3-border-left w3-leftbar w3-pale-blue w3-border-blue'>";
			echo "<p class='w3-container'>Tweet $divno of 10</p>";
			print "<p class='w3-container'>".$text."</p>"."<p class='w3-container'>Tweeted on: </p>"."<p class='w3-container'>".str_replace("+0000","",$timestamp,$replacecount)."</p>";
			echo "</div>";
                        echo "<br>";
             echo "</div>";

			$divno = $divno + 1;
		}
	}
?>