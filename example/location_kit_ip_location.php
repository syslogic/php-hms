<html lang="en">
    <head>
        <title>LocationKit IP Location Example</title>
    </head>
    <body>
    <?php
        use HMS\LocationKit\LocationKit;
        $ip_address = '8.8.8.8';
        $api = new LocationKit( [
            'app_id' => getenv('HUAWEI_OAUTH2_CLIENT_ID'),
            'app_secret' => getenv('HUAWEI_OAUTH2_CLIENT_SECRET')
        ] );
        if ( $api->is_ready() ) {
            $location = $api->getIPLocation($ip_address);

        }
    ?>
    </body>
</html>
