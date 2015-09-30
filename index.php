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
  //$userNode = $response->getGraphUser();
  $userNode = $response->getDecodedBody();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

//echo 'Logged in as ' . $userNode->getName();
echo 'Logged in as ' . var_dump($userNode);
?>
