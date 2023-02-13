<?php
require_once '../vendor/autoload.php';

use HMS\AccountKit\AccountKit;
use HMS\WalletKit\WalletKit;

// appending 'redirect_walletkit' to the $oauth2_redirect_url.
if (isset($_SERVER['HUAWEI_OAUTH2_REDIRECT_URL'])) {
    $_SERVER['HUAWEI_OAUTH2_REDIRECT_URL'] = $_SERVER['HUAWEI_OAUTH2_REDIRECT_URL'] . 'redirect_walletkit';
}
include './oauth2.php';
?>
<html lang="en">
    <head>
        <title>WalletKit Example</title>
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
        if (isset($error)) {echo $error;}
        if (isset($_POST) && isset($_POST['query'])) {
            if (isset( $token_response ) && property_exists($token_response, 'access_token')) {
                $wallet = new WalletKit( ['access_token' => $token_response->access_token] );
                $result = $wallet->eventTicketModel()->create([

                ]);
                echo '<pre>' . print_r($result, true) . '</pre>';

                if ($result->code == 401) {
                    echo '<p><button onclick=redirect()>Login with HUAWEI ID</button></p>';
                }
            }
        } else {
            echo '<p><button onclick=redirect()>Login with HUAWEI ID</button></p>';
        }
        ?>
        </div>
    </body>
</html>
