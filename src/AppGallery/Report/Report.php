<?php /** @noinspection PhpUnused */
namespace HMS\AppGallery\Report;

use HMS\AppGallery\Connect;

/**
 * Class HMS AppGallery Connect Report Wrapper
 *
 * @author Martin Zeitler
 */
class Report extends Connect {

    public function __construct( array|string $config ) {
        parent::__construct( $config );
    }

}
