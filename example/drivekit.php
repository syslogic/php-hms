<?php
require_once '../vendor/autoload.php';

use HMS\AccountKit\AccountKit;
use HMS\DriveKit\DriveKit;
// error_reporting(-1);

$token_path = '../../.credentials/huawei_token.json';
if (! is_writeable($token_path)) {die( 'unable to cache the token: '.$token_path );}
if (! isset($_SERVER['HUAWEI_OAUTH2_CLIENT_ID'])) {die( 'missing variable: HUAWEI_OAUTH2_CLIENT_ID' );}
if (! isset($_SERVER['HUAWEI_OAUTH2_CLIENT_SECRET'])) {die( 'missing variable: HUAWEI_OAUTH2_CLIENT_SECRET' );}
if (! isset($_SERVER['HUAWEI_OAUTH2_REDIRECT_URL'])) {die( 'missing variable: HUAWEI_OAUTH2_REDIRECT_URL' );}
if (! isset($_SERVER['HUAWEI_OAUTH2_API_SCOPE'])) {die( 'missing variable: HUAWEI_OAUTH2_API_SCOPE' );}

$api = new AccountKit( [
    'oauth2_client_id' => $_SERVER['HUAWEI_OAUTH2_CLIENT_ID'],
    'oauth2_client_secret' => $_SERVER['HUAWEI_OAUTH2_CLIENT_SECRET'],
    'oauth2_redirect_url' => $_SERVER['HUAWEI_OAUTH2_REDIRECT_URL'],
    'oauth2_api_scope' => $_SERVER['HUAWEI_OAUTH2_API_SCOPE'],
    'debug_mode' => true
]);

// https://developer.huawei.com/consumer/en/doc/development/HMSCore-Guides/web-get-access-token-0000001050048946#section151118514311
if (isset($_GET['code'])) {
    $token_response = $api->get_access_token_by_auth_code( $_GET['code'] );
    if ($token_response != null) {
        // convert the expiry timestamp from relative to absolute value.
        if (property_exists($token_response, 'expires_in')) {
            $token_response->expiry = time() + $token_response->expires_in;
            unset($token_response->expires_in);
        }
        file_put_contents($token_path, $token_response);
    }
} else if (file_exists($token_path) && filesize($token_path) > 2) {

    // load previously authorized token from a file, if it exists.
    $token_response = json_decode(file_get_contents($token_path), true);

    /* TODO: determine token expiry, perform token refresh. */
    if ($token_response->expiry >= time()) {
        $token_response = $api->get_access_token_by_refresh_token( $token_response->refresh_token );
    }
}

if (isset($token_response)) {
    $drive = new DriveKit( ['access_token' => $token_response->access_token] );
    $result = $drive->getAbout()->get();
}
?>
<html lang="en">
    <head>
        <title>DriveKit Example</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <script type="text/javascript">function redirect() {
            window.location.href = '<?= $api->get_login_url(); ?>';
        }
        </script>
    </head>
    <body>
        <p>
            <button onclick=redirect()>Login with HUAWEI ID</button>
        </p>
        <p>
            <?php
                if (isset($result) && is_object($result)) {
                    die('<pre>' . print_r($result, true) . '</pre>');
                }
            ?>
        </p>
    </body>
</html>
