<html>
    <head>
    </head>
    <body>
    <?php
    /**
     * AccountKit Example
     *
     * @author Martin Zeitler
     */
    use HMS\AccountKit\AccountKit;
    $config = [
        'client_id' => getenv('HUAWEI_APP_ID'),
        'client_secret' => getenv('HUAWEI_APP_SECRET')
    ];
    $api = new AccountKit( $config );
    if ( $api->is_ready() ) {

    }
    ?>
    </body>
</html>
