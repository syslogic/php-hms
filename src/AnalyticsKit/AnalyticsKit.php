<?php
namespace HMS\AnalyticsKit;

use HMS\Core\Wrapper;

/**
 * Class HMS AnalyticsKit Wrapper
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/android-api-common-interface-description-0000001050707180">AnalyticsKit</a>
 * @author Martin Zeitler
 */
class AnalyticsKit extends Wrapper {

    public function __construct( array $config ) {
        parent::__construct( $config, 3 ); // unsure if 2 or 3 applies.
    }
}
