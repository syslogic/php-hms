<?php /** @noinspection PhpUnused */
namespace HMS\DriveKit\Comments;

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

    /**
     * @param string $file_id The file ID.
     * @param string $fields     Fields in the request, which are in the partial response format.
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/server-api-commentslist-0000001050151714">Comments:list</a>
     * @return bool|stdClass The result of the API call.
     */
    public function list( string $file_id, string $fields='*' ): stdClass|bool {
        $url = str_replace('{fileId}', $file_id, Constants::DRIVE_KIT_COMMENTS_URL);
        return $this->request( 'GET', $url, $this->auth_headers(), [
            'fields' => $fields
        ]);
    }

    /**
     * @param string $file_id    The file ID.
     * @param string $comment_id The comment ID.
     * @param string $fields     Fields in the request, which are in the partial response format.
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/server-api-commentsget-0000001050153665">Comments:get</a>
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
     * @param string $file_id The file ID.
     * @param string $content Comment content.
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/server-api-commentscreate-0000001050151716">Comments:create</a>
     * @return bool|stdClass The result of the API call.
     */
    public function create( string $file_id, string $content ): stdClass|bool {
        $url = str_replace('{fileId}', $file_id, Constants::DRIVE_KIT_COMMENTS_URL . '?fields=*');
        return $this->request( 'POST', $url, $this->auth_headers(), [
            'description' => $content
        ]);
    }

    /**
     * @param string $file_id The file ID.
     * @param string $comment_id The comment ID.
     * @param string $content Comment content.
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/server-api-commentsupdate-0000001050153667">Comments:update</a>
     * @return bool|stdClass The result of the API call.
     */
    public function update( string $file_id, string $comment_id, string $content ): stdClass|bool {
        $url = str_replace(['{fileId}', '{commentId}'], [$file_id, $comment_id], Constants::DRIVE_KIT_COMMENT_URL . '?fields=*');
        return $this->request( 'PATCH', $url, $this->auth_headers(), [
            'description' => $content
        ]);
    }

    /**
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/server-api-commentsdelete-0000001050151718">Comments:delete</a>
     * @return bool The result of the API call.
     */
    public function delete( string $file_id, string $comment_id ): bool {
        $url = str_replace(['{fileId}', '{commentId}'], [$file_id, $comment_id], Constants::DRIVE_KIT_COMMENT_URL);
        $result = $this->request( 'DELETE', $url, $this->auth_headers());
        return $result->code == 204;
    }
}
