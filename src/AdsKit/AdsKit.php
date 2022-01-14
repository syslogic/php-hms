<?php
namespace HMS\AdsKit;

use HMS\Core\Wrapper;

/**
 * Class HMS AdsKit Wrapper
 *
 * @author Martin Zeitler
 */
class AdsKit extends Wrapper {

    public function __construct( array $config ) {
        parent::__construct( $config, 3 ); // unsure if 2 or 3 applies.
    }
}
