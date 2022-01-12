<?php
namespace HMS\Connect;

use HMS\Core\Wrapper;

/**
 * Class HMS AppGallery Connect Wrapper
 *
 * @author Martin Zeitler
 */
class Connect extends Wrapper {

    public function __construct( array $config ) {
        parent::__construct( $config );
    }

    /**
     * Submission Callback.
     *
     * TODO: emulate & process post-back.
     * @see https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-notify-release-0000001158245063
     */
    public function notify_release(): bool {
        return true;
    }
}
