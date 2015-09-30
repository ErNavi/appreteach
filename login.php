<?php
require_once __DIR__ . '/facebook-sdk-v5/autoload.php';
session_start();

$fb = new Facebook\Facebook([
    'app_id' => '1480036835633971',
    'app_secret' => '81daf23dbc2099501a2c1dceb1e7856e',
    'default_graph_version' => 'v2.2',
]);

$helper = $fb->getRedirectLoginHelper();
//$permissions = ['email', 'user_likes']; // optional
$loginUrl = $helper->getLoginUrl('http://appreteach.azurewebsites.net//login-callback.php', $permissions);

echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';