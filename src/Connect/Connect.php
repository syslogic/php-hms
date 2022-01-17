<?php
namespace HMS\Connect;

use HMS\Core\Wrapper;

/**
 * Class HMS AppGallery Connect Wrapper
 *
 * @author Martin Zeitler
 */
class Connect extends Wrapper {

    public function __construct( array|string $config ) {
        parent::__construct( $config );
    }

    /**
     * On Submission Callback
     * TODO: emulate & process post-back.
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-notify-release-0000001158245063">Submission Callback</a>
     */
    public function on_submission_callback(): bool {
        $key_file = '/var/www/.credentials/agconnect.pem';
        $item = new SubmissionCallback( $key_file );

        return true; // TODO
    }
}
