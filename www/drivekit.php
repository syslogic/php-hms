<?php
require_once '../vendor/autoload.php';

use HMS\AccountKit\AccountKit;
use HMS\DriveKit\DriveKit;

// appending '/drivekit' to $oauth2_redirect_url.
if (isset($_SERVER['HUAWEI_OAUTH2_REDIRECT_URL'])) {
    $_SERVER['HUAWEI_OAUTH2_REDIRECT_URL'] = $_SERVER['HUAWEI_OAUTH2_REDIRECT_URL'] . '/drivekit';
}
// appending 'drive.readonly' to $oauth2_api_scope.
if (isset($_SERVER['HUAWEI_OAUTH2_API_SCOPE'])) {
    // $_SERVER['HUAWEI_OAUTH2_API_SCOPE'] = $_SERVER['HUAWEI_OAUTH2_API_SCOPE'] . ' https://www.huawei.com/auth/drive.readonly';
    $_SERVER['HUAWEI_OAUTH2_API_SCOPE'] = $_SERVER['HUAWEI_OAUTH2_API_SCOPE'] . ' https://www.huawei.com/auth/drive';
}
include './oauth2.php';
?>
<html lang="en">
    <head>
        <title>DriveKit Example</title>
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
                $drive = new DriveKit( ['access_token' => $token_response->access_token] );
                $result = $drive->getAbout()->get();
                if (property_exists($result, 'code') && $result->code == 401) {
                    echo '<p><button onclick=redirect()>Login with HUAWEI ID</button></p>';
                } else {
                    echo '<pre>' . print_r($result, true) . '</pre>';

                    $result = $drive->getFiles()->create_folder("PHP-HMS");
                    echo '<pre>' . print_r($result, true) . '</pre>';

                    $result = $drive->getFiles()->list();
                    echo '<pre>' . print_r($result, true) . '</pre>';
                }
            } else {
                echo '<p><button onclick=redirect()>Login with HUAWEI ID</button></p>';
            }
        ?>
        </div>
    </body>
</html>
