<?php
require_once '../vendor/autoload.php';

use HMS\AccountKit\AccountKit;
use HMS\DriveKit\DriveKit;

// appending 'redirect_drivekit' to the $oauth2_redirect_url.
$oauth2_redirect = 'redirect_drivekit';
if (isset($_SERVER['HUAWEI_OAUTH2_REDIRECT_URL']) && ! str_contains($_SERVER['HUAWEI_OAUTH2_REDIRECT_URL'], $oauth2_redirect)) {
    $_SERVER['HUAWEI_OAUTH2_REDIRECT_URL'] = $_SERVER['HUAWEI_OAUTH2_REDIRECT_URL'] . $oauth2_redirect;
}
// appending 'drive' (read/write) to $oauth2_api_scope.
$oauth2_scope = 'https://www.huawei.com/auth/drive';
if (isset($_SERVER['HUAWEI_OAUTH2_API_SCOPE']) && ! str_contains($_SERVER['HUAWEI_OAUTH2_API_SCOPE'], $oauth2_scope)) {
    $_SERVER['HUAWEI_OAUTH2_API_SCOPE'] = $_SERVER['HUAWEI_OAUTH2_API_SCOPE'] . ' ' . $oauth2_scope;
}
include './oauth2.php';
?>
<html lang="en">
    <head>
        <title>DriveKit Example</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <style>
            div.image_png {background-color: #E1E1E1;}
        </style>
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
        if (isset( $token_response ) && property_exists($token_response, 'access_token')) {
                $drive = new DriveKit( ['access_token' => $token_response->access_token] );
                $result = $drive->getAbout()->get();
                if (property_exists($result, 'code') && $result->code == 401) {
                    echo '<p><button onclick=redirect()>Login with HUAWEI ID</button></p>';
                } else {

                    // About
                    echo '<div>Domain: '. $result->domain . '</div>';
                    echo '<div>Permission ID: '. $result->user->permissionId . '</div>';
                    echo '<div>User: '. $result->user->displayName . '</div>';
                    echo '<div>Capacity: '. format_filesize($result->storageQuota->userCapacity) . '</div>';
                    echo '<div>Used: ' . format_filesize($result->storageQuota->usedSpace) . '</div>';

                    // List
                    $result = $drive->getFiles()->list();
                    foreach ($result->files as $file) {
                        echo '<div class="'.str_replace('/','_', $file->mimeType).'">'.$file->mimeType.' '.format_filesize($file->size).' '.$file->fileName.'</div>';
                    }
                    if (property_exists($result, 'nextCursor')) {}
                    // $drive->getFiles()->delete_by_name('');
                }
            } else {
                echo '<p><button onclick=redirect()>Login with HUAWEI ID</button></p>';
            }
        ?>
        </div>
    </body>
</html>
