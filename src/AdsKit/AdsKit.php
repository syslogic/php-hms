<?php
namespace HMS\AdsKit;

use HMS\Core\Wrapper;

/**
 * Class HMS AdsKit Wrapper
 *
 * @author Martin Zeitler
 */
class AdsKit extends Wrapper {

    public function __construct( array|string $config ) {
        parent::__construct( $config, 3 );
    }
}
