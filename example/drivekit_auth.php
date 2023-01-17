<?php

use HMS\AccountKit\AccountKit;

/* https://developer.huawei.com/consumer/en/doc/development/HMSCore-Guides/web-get-access-token-0000001050048946#section151118514311 */
if (isset($_GET['code'])) {
    $api = new AccountKit( [
        'client_id' => $_SERVER['HUAWEI_OAUTH2_CLIENT_ID'],
        'client_secret' => $_SERVER['HUAWEI_OAUTH2_CLIENT_SECRET'],
        'redirect_uri' => $_SERVER['HUAWEI_OAUTH2_REDIRECT_URL']
    ]);
    $result = $api->get_access_token_by_auth_code( $_GET['code'] );
    die('<pre>' . print_r($result, true) . '</pre>');
}
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
                url += '&redirect_uri=<?=$_SERVER['HUAWEI_OAUTH2_REDIRECT_URL'];?>';
                url += '&scope=<?=$_SERVER['HUAWEI_OAUTH2_API_SCOPE'];?>';
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
