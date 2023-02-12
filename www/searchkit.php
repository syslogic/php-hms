<?php
require_once '../vendor/autoload.php';

use HMS\AccountKit\AccountKit;
use HMS\SearchKit\SearchKit;

// appending 'redirect_searchkit' to the $oauth2_redirect_url.
if (isset($_SERVER['HUAWEI_OAUTH2_REDIRECT_URL'])) {
    $_SERVER['HUAWEI_OAUTH2_REDIRECT_URL'] = $_SERVER['HUAWEI_OAUTH2_REDIRECT_URL'] . 'redirect_searchkit';
}
include './oauth2.php';
?>
<html lang="en">
    <head>
        <title>SearchKit Example</title>
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
            <form method="post">
                <label>
                    Query:
                    <input type="text" name="query">
                </label>
                <input type="submit">
            </form>
        </div>
        <div>
        <?php
        if (isset($_POST) && isset($_POST['query'])) {
            if (isset( $token_response ) && property_exists($token_response, 'access_token')) {
                $search = new SearchKit( ['access_token' => $token_response->access_token] );

                $result1 = $search->web_search('test search');
                echo '<pre>' . print_r($result1, true) . '</pre>';

                $result2 = $search->image_search('test search');
                echo '<pre>' . print_r($result2, true) . '</pre>';

                $result3 = $search->video_search('test search');
                echo '<pre>' . print_r($result3, true) . '</pre>';

                $result4 = $search->news_search('test search');
                echo '<pre>' . print_r($result4, true) . '</pre>';

                if ($result1->code == 401 || $result2->code == 401 || $result3->code == 401 || $result4->code == 401) {
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
