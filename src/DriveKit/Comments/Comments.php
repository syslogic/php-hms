<?php /** @noinspection PhpUnused */
namespace HMS\DriveKit\Comments;

use HMS\DriveKit\Constants;
use HMS\DriveKit\DriveKit;
use stdClass;

/**
 * Class HMS DriveKit API: Comments
 *
 * @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/server-api-commentslist-0000001050151714 Comments
 * @author Martin Zeitler
 */
class Comments extends DriveKit {

    /**
     * @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/server-api-commentslist-0000001050151714 Comments:list
     * @param string $file_id The file ID.
     * @param string $fields     Fields in the request, which are in the partial response format.
     * @return bool|stdClass The result of the API call.
     */
    public function list( string $file_id, string $fields='*' ): stdClass|bool {
        $url = str_replace('{fileId}', $file_id, Constants::DRIVE_KIT_COMMENTS_URL);
        return $this->request( 'GET', $url, $this->auth_headers(), [
            'fields' => $fields
        ]);
    }

    /**
     * @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/server-api-commentsget-0000001050153665 Comments:get
     * @param string $file_id    The file ID.
     * @param string $comment_id The comment ID.
     * @param string $fields     Fields in the request, which are in the partial response format.
     * @return bool|stdClass The result of the API call.
     */
    public function get( string $file_id, string $comment_id, string $fields='*' ): stdClass|bool {
        $url = str_replace(['{fileId}', '{commentId}'], [$file_id, $comment_id], Constants::DRIVE_KIT_COMMENT_URL);
        return $this->request( 'GET', $url, $this->auth_headers(), [
            'commentId' => $comment_id,
            'fields' => $fields
        ]);
    }

    /**
     * @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/server-api-commentscreate-0000001050151716 Comments:create
     * @param string $file_id The file ID.
     * @param string $content Comment content.
     * @return bool|stdClass The result of the API call.
     */
    public function create( string $file_id, string $content ): stdClass|bool {
        $url = str_replace('{fileId}', $file_id, Constants::DRIVE_KIT_COMMENTS_URL . '?fields=*');
        return $this->request( 'POST', $url, $this->auth_headers(), [
            'description' => $content
        ]);
    }

    /**
     * @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/server-api-commentsupdate-0000001050153667 Comments:update
     * @param string $file_id The file ID.
     * @param string $comment_id The comment ID.
     * @param string $content Comment content.
     * @return bool|stdClass The result of the API call.
     */
    public function update( string $file_id, string $comment_id, string $content ): stdClass|bool {
        $url = str_replace(['{fileId}', '{commentId}'], [$file_id, $comment_id], Constants::DRIVE_KIT_COMMENT_URL . '?fields=*');
        return $this->request( 'PATCH', $url, $this->auth_headers(), [
            'description' => $content
        ]);
    }

    /**
     * @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/server-api-commentsdelete-0000001050151718 Comments:delete
     * @param string $file_id The file ID.
     * @param string $comment_id The comment ID.
     * @return bool The result of the API call.
     */
    public function delete( string $file_id, string $comment_id ): bool {
        $url = str_replace(['{fileId}', '{commentId}'], [$file_id, $comment_id], Constants::DRIVE_KIT_COMMENT_URL);
        $result = $this->request( 'DELETE', $url, $this->auth_headers());
        return $result->code == 204;
    }
}
