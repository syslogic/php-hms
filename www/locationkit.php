<?php
require_once '../vendor/autoload.php';
use HMS\AccountKit\AccountKit;
use HMS\LocationKit\LocationKit;

// appending '/locationkit' to the $oauth2_redirect_url.
if (isset($_SERVER['HUAWEI_OAUTH2_REDIRECT_URL'])) {
    $_SERVER['HUAWEI_OAUTH2_REDIRECT_URL'] = $_SERVER['HUAWEI_OAUTH2_REDIRECT_URL'] . 'redirect_locationkit';
}
include './oauth2.php';
?>
<html lang="en">
<head>
    <title>LocationKit Example</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <script type="text/javascript">function redirect() {
            window.location.href = '<?= /** @var AccountKit $api
             * @noinspection PhpRedundantVariableDocTypeInspection
             */ $api->get_login_url(); ?>';
        }
    </script>
</head>
<body>
<div>
    <?php
    if (isset($error)) {echo '' . $error . '';}
    if (isset( $token_response ) && property_exists($token_response, 'access_token')) {
        $location = new LocationKit( ['access_token' => $token_response->access_token] );
        $result = $location->getIpLocation( '8.8.8.8' );
        if (property_exists($result, 'code') && $result->code == 401) {
            echo '<p><button onclick=redirect()>Login with HUAWEI ID</button></p>';
        }
    } else {
        echo '<p><button onclick=redirect()>Login with HUAWEI ID</button></p>';
    }
    ?>
</div>
</body>
</html>
