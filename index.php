<?php 
require_once __DIR__ . '/facebook-sdk-v5/autoload.php';
session_start();
$fb = new Facebook\Facebook([
    'app_id' => '1480036835633971',
    'app_secret' => '81daf23dbc2099501a2c1dceb1e7856e',
    'default_graph_version' => 'v2.2',
]);
$helper = $fb->getRedirectLoginHelper();
// First check if this is an existing PHP session
if ( isset( $_SESSION ) && isset( $_SESSION['facebook_access_token'] ) ) {
    // create new session from the existing PHP sesson
    $session = new FacebookSession( $_SESSION['facebook_access_token'] );
    try {
        // validate the access_token to make sure it's still valid
        if ( !$session->validate() ) $session = null;
    } catch ( Exception $e ) {
        // catch any exceptions and set the sesson null
        $session = null;
        echo 'No session: '.$e->getMessage();
    }
}  elseif ( empty( $session ) ) {
    // the session is empty, we create a new one
    try {
        // the visitor is redirected from the login, let's pickup the session
        $session = $helper->getSessionFromRedirect();
    } catch( FacebookRequestException $e ) {
        // Facebook has returned an error
        echo 'Facebook (session) request error: '.$e->getMessage();
    } catch( Exception $e ) {
        // Any other error
        echo 'Other (session) request error: '.$e->getMessage();
    }
}

if ( isset( $session ) ) {
    // store the session token into a PHP session
    $_SESSION['facebook_access_token'] = $session->getToken();
    // and create a new Facebook session using the cururent token
    // or from the new token we got after login
    $session = new FacebookSession( $session->getToken() );
    try {
        // with this session I will post a message to my own timeline
        $request = new FacebookRequest(
            $session,
            'POST',
            '/me/feed',
            array(
                'link' => 'www.finalwebsites.com/facebook-api-php-tutorial/',
                'message' => 'A step by step tutorial on how to use Facebook PHP SDK v4.0'
            )
        );
        $response = $request->execute();
        $graphObject = $response->getGraphObject();
        // the POST response object
        echo '<pre>' . var_dump( $graphObject, 1 ) . '</pre>';
        $msgid = $graphObject->getProperty('id');
    } catch ( FacebookRequestException $e ) {
        // show any error for this facebook request
        echo 'Facebook (post) request error: '.$e->getMessage();
    }


if ( isset ( $msgid ) ) {
    // we only need to the sec. part of this ID
    $parts = explode('_', $msgid);
    try {
        $request2 = new FacebookRequest(
            $session,
            'GET',
            //'/'.$parts[0]
            '/'.$msgid
        );
        $response2 = $request2->execute();
        $graphObject2 = $response2->getGraphObject();
        // the GET response object
        echo '<pre>' . print_r( $graphObject2, 1 ) . '</pre>';
    } catch ( FacebookRequestException $e ) {
        // show any error for this facebook request
        echo 'Facebook (get) request error: '.$e->getMessage();
    }
}

} else {
    // we need to create a new session, provide a login link
    echo 'No session, please <a href="'. $helper->getLoginUrl( array( 'publish_actions' ) ).'">login</a>.';
}

echo $_SESSION['facebook_access_token'];
?>
