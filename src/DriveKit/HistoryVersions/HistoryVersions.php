<?php /** @noinspection PhpUnused */
namespace HMS\DriveKit\HistoryVersions;

use HMS\DriveKit\Constants;
use HMS\DriveKit\DriveKit;
use stdClass;

/**
 * Class HMS DriveKit API: HistoryVersions
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/server-api-commentslist-0000001050188698">HistoryVersions</a>
 * @author Martin Zeitler
 */
class HistoryVersions extends DriveKit {

    /**
     * @param string $file_id The file ID.
     * @return stdClass|bool The result of the API call.
     */
    public function list( string $file_id ): stdClass|bool {
        $url = str_replace('{fileId}', $file_id, Constants::DRIVE_KIT_HISTORY_VERSIONS_URL);
        return $this->request( 'GET', $url, $this->auth_headers());
    }

    /**
     * @param string $file_id    The file ID.
     * @param string $version_id The version ID.
     * @return bool|stdClass The result of the API call.
     */
    public function get( string $file_id, string $version_id ): stdClass|bool {
        $url = str_replace(['{fileId}', '{versionId}'], [$file_id, $version_id], Constants::DRIVE_KIT_HISTORY_VERSION_URL);
        return $this->request( 'GET', $url, $this->auth_headers());
    }

    /**
     * @param string $file_id    The file ID.
     * @param string $version_id The version ID.
     * @param bool $keep_permanent Indicates whether a historical version will be permanently kept..
     * @return bool|stdClass The result of the API call.
     */
    public function update( string $file_id, string $version_id, bool $keep_permanent = false ): stdClass|bool {
        $url = str_replace(['{fileId}', '{versionId}'], [$file_id, $version_id], Constants::DRIVE_KIT_HISTORY_VERSION_URL);
        return $this->request( 'PATCH', $url, $this->auth_headers(), [
            'keepPermanent' => $keep_permanent
        ]);
    }

    /**
     * @param string $file_id    The file ID.
     * @param string $version_id The version ID.
     * @return bool|stdClass The result of the API call.
     */
    public function content( string $file_id, string $version_id ): stdClass|bool {
        $url = str_replace(['{fileId}', '{versionId}'], [$file_id, $version_id], Constants::DRIVE_KIT_HISTORY_VERSION_URL . '?form=content');
        return $this->request( 'GET', $url, $this->auth_headers());
    }

    /**
     * @param string $file_id    The file ID.
     * @param string $version_id The version ID.
     * @return bool|stdClass The result of the API call.
     */
    public function delete( string $file_id, string $version_id ): stdClass|bool {
        $url = str_replace(['{fileId}', '{versionId}'], [$file_id, $version_id], Constants::DRIVE_KIT_HISTORY_VERSION_URL . '?fields=*');
        $result = $this->request( 'DELETE', $url, $this->auth_headers(), [
            'historyVersionId' => $version_id
        ]);
        // code 400 may be: "The resource doesn't allow to be deleted" (the only version there is).
        return $result->code == 204;
    }
}
