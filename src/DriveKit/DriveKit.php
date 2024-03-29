<?php
namespace HMS\DriveKit;

use HMS\Core\Wrapper;
use HMS\DriveKit\About\About;
use HMS\DriveKit\Batch\BatchCallback;
use HMS\DriveKit\Changes\Changes;
use HMS\DriveKit\Channels\Channels;
use HMS\DriveKit\Comments\Comments;
use HMS\DriveKit\Files\Files;
use HMS\DriveKit\HistoryVersions\HistoryVersions;
use HMS\DriveKit\Replies\Replies;
use HMS\DriveKit\SmallThumbnail\SmallThumbnail;
use HMS\DriveKit\Thumbnail\Thumbnail;

/**
 * Class HMS DriveKit Wrapper
 *
 * @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/server-public-info-0000001050159641 DriveKit
 * @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-Guides/open-platform-oauth-0000001053629189#section1022911426469 Authorization Code
 * @author Martin Zeitler
 */
class DriveKit extends Wrapper implements IDriveKit {

    /**
     * Constructor
     * Obtain user access-token from the config passed (www/drivekit.php).
     */
    public function __construct( array|string $config ) {
        parent::__construct( $config );
        if (is_array($config) && isset($config['access_token'])) {
            $this->access_token = $config['access_token'];
        } else {
            throw new \InvalidArgumentException('DriveKit requires an user access token.');
        }

        // appending 'drive' (read/write) to $this->oauth2_api_scope.
        $oauth2_scope = 'https://www.huawei.com/auth/drive';
        if (! str_contains($this->oauth2_api_scope, $oauth2_scope)) {
            $this->oauth2_api_scope = $this->oauth2_api_scope . ' ' . $oauth2_scope;
        }
        $this->post_init();
        return $this;
    }

    /** Unset properties irrelevant to the child class. */
    protected function post_init(): void {
        unset($this->api_key, $this->api_signature);
    }

    public function getAbout(): About {
        return new About( $this->config() );
    }

    public function getBatchCallback(): BatchCallback {
        return new BatchCallback( $this->config() );
    }

    public function getChanges(): Changes {
        return new Changes( $this->config() );
    }

    public function getChannels(): Channels {
        return new Channels( $this->config() );
    }

    public function getComments(): Comments {
        return new Comments( $this->config() );
    }

    public function getFiles(): Files {
        return new Files( $this->config() );
    }

    public function getHistoryVersions(): HistoryVersions {
        return new HistoryVersions( $this->config() );
    }

    public function getReplies(): Replies {
        return new Replies( $this->config() );
    }

    public function getThumbnail(): Thumbnail {
        return new Thumbnail( $this->config() );
    }

    public function getSmallThumbnail(): SmallThumbnail {
        return new SmallThumbnail( $this->config() );
    }

    private function config(): array {
        return [
            'access_token' => $this->access_token,
            'oauth2_client_id' => $this->oauth2_client_id,
            'oauth2_client_secret' => $this->oauth2_client_secret,
            'debug_mode' => $this->debug_mode
        ];
    }
}
