<?php

use HMS\AccountKit\AccountKit;
use HMS\DriveKit\DriveKit;
error_reporting(-1);
$token_path = '../../.credentials/huawei_token.json';
if (! is_writeable($token_path)) {
    die( 'unable to cache token: ' . $token_path );
}

if (! isset($_SERVER['HUAWEI_OAUTH2_REDIRECT_URL'])) {
    die( 'missing variable: HUAWEI_OAUTH2_REDIRECT_URL' );
}
if (! isset($_SERVER['HUAWEI_OAUTH2_API_SCOPE'])) {
    die( 'missing variable: HUAWEI_OAUTH2_API_SCOPE' );
}

/*
$api = new AccountKit( [
    'app_id' => $_SERVER['HUAWEI_OAUTH2_CLIENT_ID'],
    'app_secret' => $_SERVER['HUAWEI_OAUTH2_CLIENT_SECRET'],
    'oauth2_redirect_url' => $_SERVER['HUAWEI_OAUTH2_REDIRECT_URL'],
    'oauth2_api_scope' => $_SERVER['HUAWEI_OAUTH2_API_SCOPE'],
    'debug' => true
]);




// https://developer.huawei.com/consumer/en/doc/development/HMSCore-Guides/web-get-access-token-0000001050048946#section151118514311
if (isset($_GET['code'])) {
    $access_token = $api->get_access_token_by_auth_code( $_GET['code'] );
    if ($access_token != null) {
        // file_put_contents($token_path, $access_token);
        $api2 = new DriveKit( ['access_token' => $access_token] );
        $result = $api2->getAbout()->get();
        // die('<pre>' . print_r($result, true) . '</pre>');
    }
} else if (file_exists($token_path) && filesize($token_path) > 2) {
    // load previously authorized token from a file, if it exists.
    $access_token = json_decode(file_get_contents($token_path), true);
}
$oauth2_url = $api->get_login_url();
*/

?>
<html lang="en">
    <head>
        <title>DriveKit Example</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <script type="text/javascript">
            function redirect() {
                let url = 'https://oauth-login.cloud.huawei.com/oauth2/v3/authorize';
                url += '?response_type=code&access_type=offline&state=state_parameter_passthrough_value';
                url += '&client_id=<?=$_SERVER['HUAWEI_OAUTH2_CLIENT_ID'];?>';
                url += '&redirect_uri=<?=/*$_SERVER['HUAWEI_OAUTH2_REDIRECT_URL'] */'';?>';
                url += '&scope=<?= /*$_SERVER['HUAWEI_OAUTH2_API_SCOPE']; */''; ?>';
                window.location.href=url;
            }
        </script>
    </head>
    <body>
        <p>
            <button onclick=redirect()>Login with HUAWEI ID</button>
        </p>
    </body>
</html>