<?php /** @noinspection PhpUnused */
namespace HMS\DriveKit\HistoryVersions;

use HMS\DriveKit\DriveKit;
use HMS\DriveKit\Constants;

use stdClass;

/**
 * Class HMS DriveKit API: HistoryVersions
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/server-api-commentslist-0000001050188698">HistoryVersions</a>
 * @author Martin Zeitler
 */
class HistoryVersions extends DriveKit {

    /**
     * @return bool|stdClass The result of the API call.
     */
    public function list( string $fileId ): stdClass|bool {
        $url = str_replace('{fileId}', $fileId, Constants::DRIVE_KIT_HISTORY_VERSIONS_URL);
        return $this->request( 'GET', $url, $this->auth_headers(), []);
    }

    /**
     * @return bool|stdClass The result of the API call.
     */
    public function get( string $versionId ): stdClass|bool {
        return false;
    }

    /**
     * HTTP PATCH
     * @return bool|stdClass The result of the API call.
     */
    public function update( string $versionId ): stdClass|bool {
        return false;
    }

    /**
     * @return bool|stdClass The result of the API call.
     */
    public function content( string $versionId ): stdClass|bool {
        return false;
    }

    /**
     * @return bool|stdClass The result of the API call.
     */
    public function delete( string $versionId ): stdClass|bool {
        return false;
    }
}
