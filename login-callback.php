<?php
require_once __DIR__ . '/facebook-sdk-v5/autoload.php';
session_start();

$fb = new Facebook\Facebook([
    'app_id' => '1480036835633971',
    'app_secret' => '81daf23dbc2099501a2c1dceb1e7856e',
    'default_graph_version' => 'v2.2',
]);

$helper = $fb->getRedirectLoginHelper();
try {
    $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}

if (isset($accessToken)) {
    // Logged in!
    $_SESSION['facebook_access_token'] = (string) $accessToken;
    
    // Now you can redirect to another page and use the
    // access token from $_SESSION['facebook_access_token']
    header("Location: index.php");
}