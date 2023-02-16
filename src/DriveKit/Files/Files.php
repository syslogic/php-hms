<?php /** @noinspection PhpUnused */
namespace HMS\DriveKit\Files;

use HMS\DriveKit\Constants;
use HMS\DriveKit\DriveKit;
use stdClass;

/**
 * Class HMS DriveKit API: Files
 *
 * @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/server-api-filesgetmetadata-0000001050153645 Files
 * @author Martin Zeitler
 */
class Files extends DriveKit {

    private function get_mime_type( string $file_path ): string|null {
        if (! str_contains($file_path, '.')) {
            throw new \InvalidArgumentException('$file_path has no suffix: ' . $file_path);
        }
        $parts = explode('.', $file_path);
        $suffix = $parts[ sizeof($parts)-1 ];
        if (isset(Constants::DRIVE_KIT_MIME_TYPES[$suffix])) {return Constants::DRIVE_KIT_MIME_TYPES[$suffix];}
        else {throw new \InvalidArgumentException('$file_path unknown suffix: ' . $suffix);}
    }

    /**
     * @param string $file_id      File ID.
     * @param string $channel_id   A unique string that identifies this channel..
     * @param string $url          Address where notifications are sent for this channel.
     * @param string $user_token   A string that is sent to the target address along with each notification that is sent on this channel.
     * @param int $expiration_time Date and time when the notification channel expires, expressed as a Unix timestamp, in milliseconds.
     *                             File resources will expire within one day, while change resources will expire within one week.
     * @return bool|stdClass The result of the API call.
     */
    public function subscribe( string $file_id, string $channel_id, string $url, string $user_token, int $expiration_time=0 ): stdClass|bool {
        $query = ['type' => 'web_hook', 'id' => $channel_id, 'url' => $url, 'userToken' => $user_token];
        if ($expiration_time != 0) {$query['expirationTime'] = $expiration_time;}
        return $this->request( 'POST', Constants::DRIVE_KIT_FILES_URL . '/' . $file_id . '/subscribe', $this->auth_headers(), $query);
    }

    /**
     * @param string|null $query_param  A query for filtering the file results by attribute. For details, please refer to https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/server-public-info-0000001050159641#section166302011174612.
     * @param string|null $order_by     A list of sort keys separated by commas. The value options include createdTime, folder, editedTime, fileName, recycleTime, and size. Each key sorts in ascending order by default, but can be reversed with the desc modifier, for example, orderBy=folder,editedTime desc,fileName. If the number of files exceeds 100,000, orderBy is ignored.
     * @param         int $page_size    Maximum number of results to return per page. The default value is 100. The value ranges from 1 to 100. Note: It is possible that partial or empty result pages are returned before the end of the result list has been reached.
     * @param string|null $cursor       Cursor for the current page, which is obtained from nextCursor in the previous response.
     * @param string|null $containers   Query scope. The value can be drive, applicationData, or a combination of the two (separated by a comma). The default value is drive.
     * @param string|null $fields       Fields in the request, which are in the partial response format. For details, please refer to: https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/server-public-info-0000001050159641#section1550214199147.
     * @param string|null $form         Media format.
     * @param string|null $pretty_print Indicates whether to return a response in a human-readable format.
     * @param string|null $quota_id     User identifier, which can contain a maximum of 40 characters. This parameter is used to restrict the maximum number of API calls for a single user.
     * @param string|null $callback     Callback function used in JSONP requests.
     * @return bool|stdClass The result of the API call.
     */
    public function list(?string $fields=null, ?string $query_param=null, ?string $order_by=null, int $page_size=100, ?string $cursor=null,
                         ?string $containers=null, ?string $form=null, ?string $pretty_print=null,
                         ?string $quota_id=null,?string $callback=null): stdClass|bool {
        $query = [];
        if ($query_param  != null) {$query['queryParam'] = $query_param;}
        if ($order_by     != null) {$query['orderBy'] = $order_by;}
        if ($page_size    !=  100) {$query['pageSize'] = $page_size;}
        if ($order_by     != null) {$query['orderBy'] = $order_by;}
        if ($cursor       != null) {$query['cursor'] = $cursor;}
        if ($containers   != null) {$query['containers'] = $containers;}
        if ($fields       != null) {$query['fields'] = $fields;} else {$query['fields'] = '*';}
        if ($form         != null) {$query['form'] = $form;}
        if ($pretty_print != null) {$query['prettyPrint'] = $pretty_print;}
        if ($quota_id     != null) {$query['quotaId'] = $quota_id;}
        if ($callback     != null) {$query['callback'] = $callback;}

        return $this->request( 'GET', Constants::DRIVE_KIT_FILES_URL, $this->auth_headers(), $query);
    }

    /**
     * @param string $file_name               File name.
     * @param string|null $mime_type          File type. For details, please refer to Overview.
     * @param string|null $file_id            File ID.
     * @param string|null $description        Short description of the file.
     * @param array<string> $parent_folders[] Parent folder. The value can be root, applicationData, or the ID of a common folder.
     * @param bool $favorite                  Indicates whether the file has been favorited.
     * @param string|null $properties         Custom file properties that are universally visible.
     * @param string|null $original_filename  Original file name.
     * @param string|null $created_time       Time when the file is created.
     * @param string|null $edited_time        Last time when the file was modified.
     * @param string|null $app_settings       Customized app attribute.
     * @param bool $has_copy_permission       Indicates whether the current user (assuming the writer role) has permission to copy the file.
     * @param bool $has_share_permission      Indicates whether the current user (assuming the writer role) has permission to share the file.
     * @param string|null $contentExtras.thumbnail.content Thumbnail data encoded with Base64.
     * @param string|null $contentExtras.thumbnail.mimeType MIME type of the thumbnail.
     * @return bool|stdClass The result of the API call.
     */
    public function create( string $file_name, ?string $mime_type=null, ?string $file_id=null, ?string $description=null,
                            array $parent_folders=['root'], bool $favorite=false, ?string $properties=null, ?string $original_filename=null,
                            ?string $created_time=null, ?string $edited_time=null, ?string $app_settings=null,
                            bool $has_copy_permission=true, bool $has_share_permission=true): stdClass|bool {
        $query = [
            'mimeType' => $mime_type != null ? $mime_type : $this->get_mime_type($file_name),
            'fileName' => $file_name,
        ];
        if ($file_id           != null) {$query['id'] = $file_id;}
        if ($description       != null) {$query['description'] = $description;}
        if ($parent_folders    != null) {$query['parentFolder'] = $parent_folders;}
        if ($favorite                 ) {$query['favorite'] = $favorite;}
        if ($properties        != null) {$query['description'] = $properties;}
        if ($original_filename != null) {$query['originalFilename'] = $original_filename;}
        if ($created_time      != null) {$query['createdTime'] = $created_time;}
        if ($edited_time       != null) {$query['editedTime'] = $edited_time;}
        if ($app_settings      != null) {$query['appSettings'] = $app_settings;}
        if ($has_copy_permission      ) {$query['writerHasCopyPermission'] = $has_copy_permission;}
        if ($has_share_permission     ) {$query['writersHasSharePermission'] = $has_share_permission;}
        return $this->request('POST', Constants::DRIVE_KIT_FILES_URL, $this->auth_headers(), $query);
    }

    public function create_folder( string $file_name, string $parent_id='root' ): stdClass|bool {
        return $this->request('POST', Constants::DRIVE_KIT_FILES_URL, $this->auth_headers(), [
            'mimeType' => Constants::DRIVE_KIT_MIME_TYPE_FOLDER,
            'parentFolder' => [ $parent_id ],
            'fileName' => $file_name
        ]);
    }

    /** Recursion problem: the incoming value is the filename and not the resulting ID. */
    public function create_folder_structure( array $structure, string $parent_id='root' ): array|bool {
        $created_files = [];
        foreach ($structure as $file_name => $value) {
            $parent_id = $this->get_file_id( $file_name );
            if ($parent_id != null) { // if filename does not exist.
                if (is_array($value)) {
                    foreach ($value as $file_name1 ) {
                        if (is_array($file_name1)) {
                            foreach ($file_name1 as $file_name2 ) {
                                if (is_array($value)) {
                                    // ...
                                }
                                else if (is_string($file_name2)) {
                                    $created_files[] = $this->create_folder_if_not_exists( $file_name2, $parent_id );
                                }
                            }
                        } else if (is_string($file_name1)) {
                            $created_files[] = $this->create_folder_if_not_exists( $file_name1, $parent_id );
                        }
                    }
                } elseif (is_string($value)) {
                    $created_files[] = $this->create_folder_if_not_exists( $value, $parent_id );
                }
            } else {
                /* create parent directory */
                $created_files[] = $this->create_folder_if_not_exists( $file_name, 'root' );
            }
        }
        return $created_files;
    }

    public function get_file_id(string $file_name ):string|null {
        $result = $this->list('*');
        foreach ($result->files as $file) {
            if ($file->fileName == $file_name) {return $file->id;}
        }
        return null;
    }

    private function create_folder_if_not_exists( string $file_name, string $parent_id ): bool|stdClass {
        $file_id = $this->get_file_id($file_name);
        if ($file_id == null) { // if filename does not exist.
            return $this->request('POST', Constants::DRIVE_KIT_FILES_URL, $this->auth_headers(), [
                'mimeType' => Constants::DRIVE_KIT_MIME_TYPE_FOLDER,
                'parentFolder' => [ $parent_id ],
                'fileName' => $file_name
            ]);
        }
        return false;
    }

    /**
     * @param string $file_id The file ID.
     * @return bool|stdClass The result of the API call.
     */
    public function get( string $file_id ): stdClass|bool {
        return $this->request( 'GET', Constants::DRIVE_KIT_FILES_URL . '/' . $file_id, $this->auth_headers(), [
            'fileId' => $file_id
        ]);
    }

    /**
     * @param string $file_id The file ID.
     * @param string|null $quota_id User identifier, which can contain a maximum of 40 characters.
     *                              This parameter is used to restrict the maximum number of API calls for a single user.
     * @return bool|stdClass The result of the API call.
     * @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/server-api-filesgetcontent-0000001050153651 Files:get.content
     */
    public function get_content( string $file_id, ?string $quota_id=null ): stdClass|bool {
        $url = Constants::DRIVE_KIT_FILES_URL . '/' . $file_id . '?form=content';
        if ($quota_id != null) {$url .= '&quotaId=' . $quota_id;}
        return $this->request( 'GET', $url, $this->auth_headers(), ['fileId' => $file_id] );
    }

    /**
     * @param string $file_path      The path to the local file.
     * @param string|null $mime_type being determined by the filename suffix, when null is being passed.
     * @param string|null $quota_id  User identifier, which can contain a maximum of 40 characters.
     *                              This parameter is used to restrict the maximum number of API calls for a single user.
     * @return bool|stdClass The result of the API call.
     * @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/server-api-filescreatecontent-0000001050151688 Files:create.content
     */
    public function create_content( string $file_path, ?string $mime_type=null, ?string $quota_id=null ): stdClass|bool {
        $url = Constants::DRIVE_KIT_FILES_UPLOAD_URL . '?uploadType=content&fields=*'; // content or multipart.
        if ($quota_id != null) {$url .= '&quotaId=' . $quota_id;}
        if (file_exists($file_path) && is_readable($file_path)) {
            $body = file_get_contents($file_path);
            return $this->request( 'POST', $url, [
                'Content-Type' => $mime_type != null ? $mime_type : $this->get_mime_type($file_path),
                'Authorization' => ' Bearer ' . $this->access_token,
                'Accept' => 'application/json'
            ], $body );
        } else {
            return false;
        }
    }

    /**
     * @param string $file_id       The file ID.
     * @param string $fields        Fields in the request, which are in the partial response format. For details, please refer to Overview.
     * @param string|null $form     Media format.
     * @param bool $prettyPrint     Indicates whether to return a response in a human-readable format.
     * @param string|null $quotaId  User identifier, which can contain a maximum of 40 characters. This parameter is used to restrict the maximum number of API calls for a single user.
     * @param string|null $callback Callback function used in JSONP requests.
     * @param bool $autoRename      Indicates whether to automatically rename the file. If this parameter is set to true of left empty, the file will be automatically renamed. If this parameter is set to false, the file will not be automatically renamed.
     *
     * @return bool
     * @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/server-api-filescopy-0000001050151696 Files:copy
     */
    public function copy( string $file_id, string $fields='*', ?string $form=null, bool $prettyPrint=false, ?string $quotaId=null, ?string $callback=null, bool $autoRename=false ): bool {
        $query = [];
        $result = $this->request( 'POST', Constants::DRIVE_KIT_FILES_URL . '/' . $file_id. '/copy', $this->auth_headers(), $query);
        return $result->code == 204; //
    }

    /**
     * @param string|array $file_id
     * @return bool
     * @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/server-api-filesdelete-0000001050153647 Files:delete
     */
    public function delete( string|array $file_id  ): bool {
        if (is_string($file_id)) {
            $result = $this->request( 'DELETE', Constants::DRIVE_KIT_FILES_URL . '/' . $file_id, $this->auth_headers());
            return $result->code == 204; // success.
        } else if (is_array( $file_id ) && sizeof( $file_id ) > 0) {
            foreach ($file_id as $current_id) {
                $result = $this->request( 'DELETE', Constants::DRIVE_KIT_FILES_URL . '/' . $current_id, $this->auth_headers());
                if ($result->code != 204) {return false;}
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param string $containers Query scope.
     * The value can be drive, applicationData, or a combination of the two (separated by a comma).
     * The default value is drive.
     * @return bool
     * @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/server-api-filesemptyrecycle-0000001050151698 Files:emptyRecycle
     */
    public function emptyRecycle( string $containers='drive'): bool {
        $result = $this->request( 'DELETE', Constants::DRIVE_KIT_FILES_URL . '/recycle', $this->auth_headers(), [
            'containers' => $containers
        ]);
        return $result->code == 204;
    }

    public function delete_by_name( string $file_name ): bool {
        $file_id = $this->getFiles()->get_file_id( $file_name );
        if ($file_id == null) {return false;}
        return $this->delete( $file_id );
    }
}
