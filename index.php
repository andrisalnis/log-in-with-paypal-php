<?php

    #######################################################
    #Params
    $paypal_client_id = '!!! CLIENT ID GOES HERE !!!';
    $paypal_secret = '!!! SECRET GOES HERE !!!';
    $app_return_url = '!!! URL TO THIS SCRIPT !!!';

    $scope = array('openid', 'email');  #More info: https://developer.paypal.com/docs/integration/direct/identity/attributes/

    #######################################################
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require_once(dirname(__FILE__).'/paypal-sdk/autoload.php');
    use PayPal\Api\OpenIdSession;
    use PayPal\Api\OpenIdTokeninfo;
    use PayPal\Api\OpenIdUserinfo;
    use PayPal\Rest\ApiContext;
    use PayPal\Auth\OAuthTokenCredential;

    #######################################################
    #Step 1: display link to paypal
    if (!isset($_GET['code']) and !isset($_GET['error']))
    {
        $openidurl = OpenIdSession::getAuthorizationUrl($app_return_url, $scope, $paypal_client_id);
        echo 'Click here to <a href="https://www.paypal.com/webapps/auth/protocol/openidconnect'.$openidurl.'">log in with paypal</a>!';
        die();
    }

    #######################################################
    #Check return data for errors
    if (isset($_GET['error']))
    {
        die('<h1>Error:</h1><pre>'.print_r($_GET, TRUE));
    }

    #######################################################
    #Step 2: get user data
    $api_context = new ApiContext(new OAuthTokenCredential($paypal_client_id, $paypal_secret));
    $api_context->setConfig(array('mode' => 'live'));
    $token = OpenIdTokeninfo::createFromAuthorizationCode(array('code' => $_GET['code']), $paypal_client_id, $paypal_secret, $api_context);
    $user = OpenIdUserinfo::getUserinfo(json_decode($token, true), $api_context);
    $user = json_decode($user, true);

    die('<h1>Success!</h1><p>User data:</p><pre>'.print_r($user, true).'</pre>');
