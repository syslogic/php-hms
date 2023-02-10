<?php /** @noinspection PhpUnused */
namespace HMS\DriveKit\Files;

use HMS\DriveKit\DriveKit;
use HMS\DriveKit\Constants;

use stdClass;

/**
 * Class HMS DriveKit API: Files
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/server-api-filesgetmetadata-0000001050153645">Files</a>
 * @author Martin Zeitler
 */
class Files extends DriveKit {

    /**
     * @param string|null $queryParam A query for filtering the file results by attribute. For details, please refer to the Overview section.
     * @param string|null $orderBy A list of sort keys separated by commas. The value options include createdTime, folder, editedTime, fileName, recycleTime, and size. Each key sorts in ascending order by default, but can be reversed with the desc modifier, for example, orderBy=folder,editedTime desc,fileName. If the number of files exceeds 100,000, orderBy is ignored.
     * @param         int $pageSize Maximum number of results to return per page. The default value is 100. The value ranges from 1 to 100. Note: It is possible that partial or empty result pages are returned before the end of the result list has been reached.
     * @param string|null $cursor Cursor for the current page, which is obtained from nextCursor in the previous response.
     * @param string|null $containers Query scope. The value can be drive, applicationData, or a combination of the two (separated by a comma). The default value is drive.
     * @param string|null $fields Fields in the request, which are in the partial response format. For details, please refer to Overview.
     * @param string|null $form Media format.
     * @param string|null $prettyPrint Indicates whether to return a response in a human-readable format.
     * @param string|null $quotaId User identifier, which can contain a maximum of 40 characters. This parameter is used to restrict the maximum number of API calls for a single user.
     * @param string|null $callback Callback function used in JSONP requests.
     * @return bool|stdClass The result of the API call.
     */
    public function list(?string $queryParam=null, ?string $orderBy=null, int $pageSize=100, ?string $cursor=null,
                         ?string $containers=null, ?string $fields=null, ?string $form=null, ?string $prettyPrint=null,
                         ?string $quotaId=null,?string $callback=null): stdClass|bool {
        $query = [];
        if ($queryParam != null) {$query['queryParam'] = $queryParam;}
        if ($orderBy != null) {$query['orderBy'] = $orderBy;}
        if ($pageSize != 100) {$query['pageSize'] = $pageSize;}
        if ($orderBy != null) {$query['orderBy'] = $orderBy;}
        if ($cursor != null) {$query['cursor'] = $cursor;}
        if ($containers != null) {$query['containers'] = $containers;}
        if ($fields != null) {$query['fields'] = $fields;}
        if ($form != null) {$query['form'] = $form;}
        if ($prettyPrint != null) {$query['prettyPrint'] = $prettyPrint;}
        if ($quotaId != null) {$query['quotaId'] = $quotaId;}
        if ($callback != null) {$query['callback'] = $callback;}

        return $this->guzzle_get(Constants::DRIVE_KIT_FILES_URL, $this->auth_headers(), $query);
    }

    /**
     * @param string $file_id The file ID.
     * @return bool|stdClass The result of the API call.
     */
    public function get( string $file_id ): stdClass|bool {
        return $this->guzzle_get(Constants::DRIVE_KIT_FILES_URL . '/' . $file_id, $this->auth_headers(), [
            'fileId' => $file_id
        ]);
    }

    public function create( ): bool {
        return $this->guzzle_post(Constants::DRIVE_KIT_FILES_URL, $this->auth_headers(), [

        ]);
    }

    public function copy( ): bool {
        return false;
    }

    public function delete( ): bool {
        return false;
    }
}
