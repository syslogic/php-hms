<?php
namespace HMS\DriveKit;

use HMS\Core\Wrapper;
use HMS\DriveKit\About\About;
use HMS\DriveKit\Changes\Changes;
use HMS\DriveKit\Channels\Channels;
use HMS\DriveKit\Comments\Comments;
use HMS\DriveKit\Files\Files;
use HMS\DriveKit\Thumbnail\Thumbnail;
use InvalidArgumentException;

/**
 * Class HMS DriveKit Wrapper
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/server-public-info-0000001050159641">DriveKit</a>
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-Guides/open-platform-oauth-0000001053629189#section1022911426469">Authorization Code</a>
 * @author Martin Zeitler
 */
class DriveKit extends Wrapper {

    /**
     * Constructor
     * Obtain user access-token from the config passed (www/drivekit.php).
     */
    public function __construct( array|string $config ) {
        parent::__construct( $config );
        if (is_array($config) && isset($config['access_token'])) {
            $this->access_token = $config['access_token'];
        } else {
            throw new InvalidArgumentException('DriveKit requires an user access token.');
        }
        $this->post_init();
    }

    /** Unset properties irrelevant to the child class. */
    protected function post_init(): void {
        unset($this->api_key, $this->api_signature);
    }

    private function config(): array {
        return [
            'access_token' => $this->access_token,
            'oauth2_client_id' => $this->oauth2_client_id,
            'oauth2_client_secret' => $this->oauth2_client_secret,
            'debug_mode' => $this->debug_mode
        ];
    }

    public function getAbout(): About {
        return new About( $this->config() );
    }

    public function getFiles(): Files {
        return new Files( $this->config() );
    }
    public function getChannels(): Channels {
        return new Channels( $this->config() );
    }
    public function getThumbnail(): Thumbnail {
        return new Thumbnail( $this->config() );
    }

    public function getChanges(): Changes {
        return new Changes( $this->config() );
    }

    public function getComments(): Comments {
        return new Comments( $this->config() );
    }
}
