<?php
namespace HMS\DriveKit;

use HMS\AccountKit\AccountKit;
use HMS\Core\Wrapper;
use HMS\DriveKit\About\About;
use HMS\DriveKit\Changes\Changes;
use HMS\DriveKit\Comments\Comments;
use HMS\DriveKit\Files\Files;
use stdClass;

/**
 * Class HMS DriveKit Wrapper
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/server-public-info-0000001050159641">DriveKit</a>
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-Guides/open-platform-oauth-0000001053629189#section1022911426469">Authorization Code</a>
 * @author Martin Zeitler
 */
class DriveKit extends Wrapper {

    /** Constructor */
    public function __construct( array|string $config ) {
        parent::__construct( $config );
        $this->post_init();
    }

    /** Unset properties irrelevant to the child class. */
    protected function post_init(): void {
        unset($this->api_key, $this->api_signature);
    }

    public function getAbout(): About {
        return new About( ['app_id' => $this->app_id, 'app_secret' => $this->app_secret, 'debug' => $this->debug_mode] );
    }

    public function getFiles(): Files {
        return new Files( ['app_id' => $this->app_id, 'app_secret' => $this->app_secret, 'debug' => $this->debug_mode] );
    }

    public function getChanges(): Changes {
        return new Changes( ['app_id' => $this->app_id, 'app_secret' => $this->app_secret, 'debug' => $this->debug_mode] );
    }

    public function getComments(): Comments {
        return new Comments( ['app_id' => $this->app_id, 'app_secret' => $this->app_secret, 'debug' => $this->debug_mode] );
    }
}
