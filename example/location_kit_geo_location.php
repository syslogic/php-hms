<html lang="en">
    <head>
        <title>LocationKit GeoLocation Example</title>
    </head>
    <body>
    <?php
        use HMS\LocationKit\LocationKit;
        $geo_location = 'Munich';
        $api = new LocationKit( [
            'app_id' => getenv('HUAWEI_OAUTH2_CLIENT_ID'),
            'app_secret' => getenv('HUAWEI_OAUTH2_CLIENT_SECRET')
        ] );
        if ( $api->is_ready() ) {
            $location = $api->getGeoLocation($geo_location);

        }
    ?>
    </body>
</html>
