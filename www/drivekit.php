<?php
require_once '../vendor/autoload.php';
use HMS\DriveKit\DriveKit;
include './oauth2.php';
?>
<html lang="en">
    <head>
        <title>DriveKit Example</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <script type="text/javascript">function redirect() {
            window.location.href = '<?= /** @var \HMS\AccountKit\ $api */ $api->get_login_url(); ?>';
        }
        </script>
    </head>
    <body>
    <?php
    if (isset( $token_response ) && property_exists($token_response, 'access_token')) {
            $drive = new DriveKit( ['access_token' => $token_response->access_token] );
            $result = $drive->getAbout()->get();
            echo '<pre>' . print_r($result, true) . '</pre>';
            if ($result->code == 401) {
                echo '<p><button onclick=redirect()>Login with HUAWEI ID</button></p>';
            }
        } else {
            echo '<p><button onclick=redirect()>Login with HUAWEI ID</button></p>';
        }
    ?>
    </body>
</html>