<html lang="en">
    <head>
        <title>AccountKit Example</title>
    </head>
    <body>
    <?php
        use HMS\AccountKit\AccountKit;
        $api = new AccountKit( [
            'app_id' => getenv('HUAWEI_OAUTH2_CLIENT_ID'),
            'app_secret' => getenv('HUAWEI_OAUTH2_CLIENT_SECRET')
        ] );
        if ( $api->is_ready() ) {

        }
    ?>
    </body>
</html>
