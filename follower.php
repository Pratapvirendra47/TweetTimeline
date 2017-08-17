<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="w3.css">   
<link rel="stylesheet" href="css/foundation.css" />
<link rel="stylesheet" href="css/docs.css" />
<style>

</style>
</head>

</html>

<?php
	error_reporting(0);
	require_once('oauth/twitteroauth.php');
	require_once('config.php');
        if($_GET['type']=='tweet'){
			getFollo($_GET['screenname']);
	}
	function getConnectionwithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret){

		$connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
  		return $connection;
	}
	function getFollo($sname)
	{
		$access_token = $_SESSION['access_token'];
		$connection = getConnectionWithAccessToken(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);

		$tweeturl = $connection->get("https://api.twitter.com/1.1/followers/ids.json?cursor=-1&stringify_ids=true&screen_name=".$sname);
		$obj = json_decode(json_encode($tweeturl));
		echo "<br>";
		$idSet = "";
		$limit = 0;
		foreach ($obj as $item)
		{
			if ( is_array( $item ) )
			{
				foreach ( $item as $sub_item )
				{
				 	if ($limit <10)
				 	{
					  $id = $sub_item;
					  $idSet = $idSet.",".$id;
					  $limit = $limit +1;
					}
				}
		  	} 
		}

		$lookupurl = $connection->get("https://api.twitter.com/1.1/users/lookup.json?user_id=".$idSet."&include_entities=true"); 
		$obj = json_decode(json_encode($lookupurl));
		echo "<div id='divList' style='height: 150px; width: 700px; max-height: 150px; max-width: 700px;'>";
		echo "<h3 class='w3-text-teal w3-margin'>Followers of <b>$sname:</b></h3><br><br>";
		foreach ($obj as $item)
		{
			$name = $item->name;
			$screenname = $item->screen_name;
			$profilepic = $item->profile_image_url_https;
			echo "<div class= 'w3-margin'>";
				echo "<img src=$profilepic style='vertical-align:middle;' title='Profile Picture'>";
				echo "<span style='padding-left:10px;'>Name: ".$name." | Screen Name: ".$screenname." | ";
				?><a id="demo" href="tweet.php?type=follower&screenname=<?php echo $screenname;?>"><button class='w3-button w3-blue'>View Tweets</button></a><?php
			echo "</span></div><hr>";
		}
	}
?>
<script>
	function submitform(screenname){
					$.ajax({      		
								type: 'GET',
								url: "tweet.php",				
								data:  '&screenname=' + screenname + '&type=' + 'follower',				
								success: function (data) {	
								var contents = $(data).html();
                                $("#newTweets").html(data);		
							   // alert(data);								
								},
								error: function (data) {							
								alert(data);								
								},
					});	
		}	
</script>