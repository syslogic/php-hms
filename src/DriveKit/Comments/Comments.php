<?php /** @noinspection PhpUnused */
namespace HMS\DriveKit\Comments;

use HMS\AccountKit\AccountKit;
use HMS\DriveKit\DriveKit;
use HMS\DriveKit\Constants;

use stdClass;

/**
 * Class HMS DriveKit API: Comments
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/server-api-commentslist-0000001050151714">Comments</a>
 * @author Martin Zeitler
 */
class Comments extends DriveKit {

    public function __construct( array $config ) {

        parent::__construct( $config );

        /* TODO: Authorization Code. */
        $account_kit = new AccountKit( $config );
        $this->access_token = $account_kit->get_access_token();
    }

    /**
     * @return bool|stdClass The result of the API call.
     */
    public function list( string $fileId ): stdClass|bool {
        $url = str_replace('{fileId}', $fileId, Constants::DRIVE_KIT_COMMENTS_URL);
        return $this->guzzle_get($url, $this->auth_headers(), []);
    }
}
