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
     * @param string|null $queryParam A query for filtering the file results by attribute. For details, please refer to https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/server-public-info-0000001050159641#section166302011174612.
     * @param string|null $orderBy A list of sort keys separated by commas. The value options include createdTime, folder, editedTime, fileName, recycleTime, and size. Each key sorts in ascending order by default, but can be reversed with the desc modifier, for example, orderBy=folder,editedTime desc,fileName. If the number of files exceeds 100,000, orderBy is ignored.
     * @param         int $pageSize Maximum number of results to return per page. The default value is 100. The value ranges from 1 to 100. Note: It is possible that partial or empty result pages are returned before the end of the result list has been reached.
     * @param string|null $cursor Cursor for the current page, which is obtained from nextCursor in the previous response.
     * @param string|null $containers Query scope. The value can be drive, applicationData, or a combination of the two (separated by a comma). The default value is drive.
     * @param string|null $fields Fields in the request, which are in the partial response format. For details, please refer to: https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/server-public-info-0000001050159641#section1550214199147.
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
     * @param string $fileName File name.
     * @param string $mimeType File type. For details, please refer to Overview.
     * @param string|null $fileId File ID.
     * @param string|null $description Short description of the file.
     * @param array<string> $parentFolder[] Parent folder. The value can be root, applicationData, or the ID of a common folder.
     * @param bool $favorite Indicates whether the file has been favorited.
     * @param string|null $properties Custom file properties that are universally visible.
     * @param string|null $originalFilename Original file name.
     * @param string|null $createdTime Time when the file is created.
     * @param string|null $editedTime Last time when the file was modified.
     * @param string|null $appSettings Customized app attribute.
     * @param bool $writerHasCopyPermission Indicates whether the current user (assuming the writer role) has permission to copy the file.
     * @param bool $writersHasSharePermission Indicates whether the current user (assuming the writer role) has permission to share the file.
     *
     * @param string|null $contentExtras.thumbnail.content Thumbnail data encoded with Base64.
     * @param string|null $contentExtras.thumbnail.mimeType MIME type of the thumbnail.
     * @return bool|stdClass The result of the API call.
     */
    public function create( string $fileName, string $mimeType='text/plain', ?string $fileId=null, ?string $description=null,
                            array $parentFolder=['root'], bool $favorite=false, ?string $properties=null, ?string $originalFilename=null,
                            ?string $createdTime=null, ?string $editedTime=null, ?string $appSettings=null,
                            bool $writerHasCopyPermission=true, bool $writersHasSharePermission=true): stdClass|bool {
        $query = ['fileName' => $fileName, 'mimeType' => $mimeType];
        if ($fileId != null) {$query['id'] = $fileId;}
        if ($description != null) {$query['description'] = $description;}
        if ($parentFolder != null) {$query['parentFolder'] = $parentFolder;}
        if ($favorite) {$query['favorite'] = $favorite;}
        if ($properties != null) {$query['description'] = $properties;}
        if ($originalFilename != null) {$query['originalFilename'] = $originalFilename;}
        if ($createdTime != null) {$query['createdTime'] = $createdTime;}
        if ($editedTime != null) {$query['editedTime'] = $editedTime;}
        if ($appSettings != null) {$query['appSettings'] = $appSettings;}
        if ($writerHasCopyPermission) {$query['writerHasCopyPermission'] = $writerHasCopyPermission;}
        if ($writersHasSharePermission) {$query['writersHasSharePermission'] = $writersHasSharePermission;}
        return $this->guzzle_post(Constants::DRIVE_KIT_FILES_URL, $this->auth_headers(), $query);
    }

    public function create_folder( string $fileName ): stdClass|bool {
        return $this->guzzle_post(Constants::DRIVE_KIT_FILES_URL, $this->auth_headers(), [
            'fileName' => $fileName,
            'mimeType' => 'application/vnd.huawei-apps.folder'
        ]);
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

    public function copy( ): bool {
        return false;
    }

    public function delete( ): bool {
        return false;
    }
}
