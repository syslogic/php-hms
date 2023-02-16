<?php /** @noinspection PhpUnused */
namespace HMS\AppGallery\Project;

use HMS\AppGallery\Connect;

/**
 * Class HMS AppGallery Connect Project Wrapper
 *
 * @author Martin Zeitler
 */
class Project extends Connect {

    /** Constructor */
    public function __construct( array|string $config ) {
        parent::__construct( $config );
    }
}
