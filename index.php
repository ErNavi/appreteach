<?php 
require_once __DIR__ . '/facebook-sdk-v5/autoload.php';
session_start();
$fb = new Facebook\Facebook([
    'app_id' => '1480036835633971',
    'app_secret' => '81daf23dbc2099501a2c1dceb1e7856e',
    'default_graph_version' => 'v2.2',
]);

if(empty($_SESSION['facebook_access_token'])){
   header('Location: login.php') ;
   }

echo $_SESSION['facebook_access_token'];
?>
