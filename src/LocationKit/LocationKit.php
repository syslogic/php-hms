<?php
namespace HMS\LocationKit;

use HMS\Core\Wrapper;

/**
 * Class HMS LocationKit Wrapper
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/web-overview-0000001052619173">LocationKit</a>
 * @author Martin Zeitler
 */
class LocationKit extends Wrapper {

    public function __construct( array $config ) {
        parent::__construct( $config, 3 ); // unsure if 2 or 3 applies.
    }
}
