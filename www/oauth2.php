<?php
require_once '../vendor/autoload.php';
use HMS\AccountKit\AccountKit;

$token_path = '../../.credentials/huawei_token.json';
if (! is_writeable($token_path)) {die( 'unable to cache the token: '.$token_path );}
if (! isset($_SERVER['HUAWEI_OAUTH2_CLIENT_ID'])) {die( 'missing variable: HUAWEI_OAUTH2_CLIENT_ID' );}
if (! isset($_SERVER['HUAWEI_OAUTH2_CLIENT_SECRET'])) {die( 'missing variable: HUAWEI_OAUTH2_CLIENT_SECRET' );}
if (! isset($_SERVER['HUAWEI_OAUTH2_REDIRECT_URL'])) {die( 'missing variable: HUAWEI_OAUTH2_REDIRECT_URL' );}
if (! isset($_SERVER['HUAWEI_OAUTH2_API_SCOPE'])) {die( 'missing variable: HUAWEI_OAUTH2_API_SCOPE' );}

$api = new AccountKit( [
    'oauth2_client_id'     => $_SERVER['HUAWEI_OAUTH2_CLIENT_ID'],
    'oauth2_client_secret' => $_SERVER['HUAWEI_OAUTH2_CLIENT_SECRET'],
    'oauth2_redirect_url'  => $_SERVER['HUAWEI_OAUTH2_REDIRECT_URL'],
    'oauth2_api_scope'     => $_SERVER['HUAWEI_OAUTH2_API_SCOPE'],
    'debug_mode'           => true
]);

// https://developer.huawei.com/consumer/en/doc/development/HMSCore-Guides/web-get-access-token-0000001050048946#section151118514311
if (isset($_GET['code'])) {
    $token_response = $api->get_access_token_by_auth_code( $_GET['code'] );
    if ($token_response != null) {
        if (property_exists($token_response, 'code') && property_exists($token_response, 'message')) {
            $error = 'Error ' . $token_response->code .' / '. $token_response->message;
        } else {
            // convert the expiry timestamp from relative to absolute value.
            file_put_contents($token_path, json_encode($token_response));
        }
    }
} else if (file_exists($token_path) && filesize($token_path) > 0) {

    // load previously authorized token from a file, if it exists.
    $token_response = (object) json_decode(file_get_contents($token_path), true);

    // determine token expiry and perform a refresh, when required.
    if (property_exists($token_response, 'expiry')) {
        if ($token_response->expiry >= time() && property_exists($token_response, 'refresh_token')) {
            $token_response = $api->get_access_token_by_refresh_token( $token_response->refresh_token );
            file_put_contents($token_path, json_encode($token_response));
        }
    }
}

if (isset($_GET['error']) && isset($_GET['sub_error']) && $_GET['error_description']) {
    $error = 'Error ' . $_GET['error'] .' / '. $_GET['sub_error'] . ' ' . $_GET['error_description'];
}
