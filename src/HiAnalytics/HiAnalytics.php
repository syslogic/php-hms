<?php
namespace HMS\HiAnalytics;

use HMS\Core\Wrapper;

/**
 * Class HMS HiAnalytics Wrapper
 *
 * @author Martin Zeitler
 */
class HiAnalytics extends Wrapper {

    public function __construct( array $config ) {
        parent::__construct( $config, 3 ); // unsure if 2 or 3 applies.
    }
}
