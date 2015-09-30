<?php 
require_once __DIR__ . '/facebook-sdk-v5/autoload.php';
session_start();
$fb = new Facebook\Facebook([
    'app_id' => '1480036835633971',
    'app_secret' => '81daf23dbc2099501a2c1dceb1e7856e',
    'default_graph_version' => 'v2.2',
]);


// Sets the default fallback access token so we don't have to pass it to each request
$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);

try {
  $response = $fb->get('/me');
  $userNode = $response->getGraphUser();
  $userId = $userNode->getId();
  $userName = $userNode->getName();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

?>

<html>
<body>
<h4><?php echo "Welcome ".$userName.". You have come to appreciate your teachers."?></h4>
<img alt="profile" src="<?php echo "https://graph.facebook.com/".$userId."/picture?type=normal" ?>"/>
</body>
</html>
