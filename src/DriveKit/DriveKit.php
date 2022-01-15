<?php
namespace HMS\DriveKit;

use HMS\Core\Wrapper;

/**
 * Class HMS DriveKit Wrapper
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/server-public-info-0000001050159641">DriveKit</a>
 * @author Martin Zeitler
 */
class DriveKit extends Wrapper {

    public function __construct( array|string $config ) {
        parent::__construct( $config, 3 );
    }
}
