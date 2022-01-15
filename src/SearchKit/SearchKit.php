<?php
namespace HMS\SearchKit;

use HMS\Core\Wrapper;

/**
 * Class HMS SearchKit Wrapper
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/overview-0000001057087079">SearchKit</a>
 * @author Martin Zeitler
 */
class SearchKit extends Wrapper {

    public function __construct( array|string $config ) {
        parent::__construct( $config, 3 );
    }
}
