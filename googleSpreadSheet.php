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
	if($_GET['type']=='tweet'){
			//echo $_GET['screenname'];
			downloadTweets($_GET['screenname']);
	}
	function getConnectionwithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret){

		$connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
  		return $connection;
	}


	function downloadTweets($sname){

		$notweets = 10;
		$consumerkey = 'ENTER YOUR CONSUMER KEY';
		$consumersecret = 'ENTER SECRET CONSUMER KEY';
		$access_token = $_SESSION['access_token'];
                
		$connection = getConnectionWithAccessToken($consumerkey, $consumersecret, $access_token, $SESSION['oauth_token_secret']);


		$tweeturl = $connection->get("https://api.twitter.com/1.1/statuses/home_timeline.json?screen_name=".$sname."&count=".$noTweets);
	        //echo json_encode($tweeturl);
		$filename = "Download/export.csv";
		$delimiter = ",";
		//echo "HELLO WORLD";
		$f = fopen($filename,'w');

		fputcsv($f, array("id_str", "created_at", "text", "name", "screen_name", "profile_image_url"), $delimiter);

		//echo "HELLO WORLD 2";
		foreach($tweeturl as $line){
			fputcsv($f, array("'" . $line -> id_str . "'", $line -> created_at, $line -> text, $line -> user -> name, $line -> user -> screen_name, $line -> user -> profile_image_url), $delimiter);
		}
		fseek($f,0);
                echo "<div class='w3-margin w3-center'>";
               echo $sname."<p>Download Your .csv file : </p><br>";
               echo "<a href='Download/export.csv'><button class='w3-button w3-black'>download</button></a>";
               echo "</div>";
		require_once 'lib/google-api-php-client/src/Google_Client.php';
		require_once 'lib/google-api-php-client/src/contrib/Google_DriveService.php';




	   $client = new Google_Client();
    // Get your credentials from the console
   		$client->setClientId('ENTER YOUR CLIENT ID');
   		$client->setClientSecret('ENTER SECRET CLIENT');
    	$client->setRedirectUri('ENTER REDIRECT URI');
    	$client->setScopes(array('https://www.googleapis.com/auth/drive'));
        $service = new Google_DriveService($client);

       $authUrl = $client->createAuthUrl();
    $authCode = trim(fgets(STDIN));
    $accessToken = $client->authenticate($authCode);
    $client->setAccessToken($accessToken);
    $file = new Google_DriveFile();
    $localfile = 'Download/export.csv';
    $title = basename($localfile);
    $file->setTitle($title);
    $file->setDescription('My File');
    $file->setMimeType('application/vnd.google-apps.photo');

    $data = file_get_contents($localfile);

    $createdFile = $service->files->insert($file, array(
          'data' => $data,
          'mimeType' => 'application/vnd.google-apps.photo',
     ));
    print_r($createdFile);
		
	}

?>
