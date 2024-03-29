<?php /** @noinspection PhpUnused */
namespace HMS\DriveKit\Replies;

use HMS\DriveKit\Constants;
use HMS\DriveKit\DriveKit;
use stdClass;

/**
 * Class HMS DriveKit API: Replies
 *
 * @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/server-api-replieslist-0000001050151720 Replies
 * @author Martin Zeitler
 */
class Replies extends DriveKit {

    /**
     * @param string $file_id    The file ID.
     * @param string $comment_id The comment ID.
     * @param string $fields     Fields in the request, which are in the partial response format.
     * @return bool|stdClass The result of the API call.
     */
    public function list( string $file_id, string $comment_id, string $fields='*' ): stdClass|bool {
        $url = str_replace(['{fileId}', '{commentId}'], [$file_id, $comment_id], Constants::DRIVE_KIT_COMMENT_REPLIES_URL . '?fields=' . $fields);
        return $this->request( 'GET', $url, $this->auth_headers(), [
            'fields' => $fields
        ]);
    }

    /**
     * @param string $file_id    The file ID.
     * @param string $comment_id The comment ID.
     * @param string $content    Reply content.
     * @param string $fields     Fields in the request, which are in the partial response format.
     * @return bool|stdClass The result of the API call.
     */
    public function create( string $file_id, string $comment_id, string $content, string $fields='*' ): stdClass|bool {
        $url = str_replace(['{fileId}', '{commentId}'], [$file_id, $comment_id], Constants::DRIVE_KIT_COMMENT_REPLIES_URL . '?fields=' . $fields);
        return $this->request( 'POST', $url, $this->auth_headers(), [
            'description' => $content
        ]);
    }

    /**
     * @param string $file_id    The file ID.
     * @param string $comment_id The comment ID.
     * @param string $reply_id   The reply ID.
     * @param string $fields     Fields in the request, which are in the partial response format.
     * @return bool|stdClass The result of the API call.
     */
    public function get( string $file_id, string $comment_id, string $reply_id, string $fields='*' ): stdClass|bool {
        $url = str_replace(['{fileId}', '{commentId}', '{replyId}'], [$file_id, $comment_id, $reply_id], Constants::DRIVE_KIT_COMMENT_REPLY_URL);
        return $this->request( 'GET', $url, $this->auth_headers(), [
            'fields' => $fields
        ]);
    }

    /**
     * @param string $file_id    The file ID.
     * @param string $comment_id The comment ID.
     * @param string $reply_id   The reply ID.
     * @param string $content    Reply content.
     * @param string $fields     Fields in the request, which are in the partial response format.
     * @return bool|stdClass The result of the API call.
     */
    public function update( string $file_id, string $comment_id, string $reply_id, string $content, string $fields='*' ): stdClass|bool {
        $url = str_replace(['{fileId}', '{commentId}', '{replyId}'], [$file_id, $comment_id, $reply_id], Constants::DRIVE_KIT_COMMENT_REPLY_URL . '?fields=' . $fields);
        return $this->request( 'PATCH', $url, $this->auth_headers(), [
            'description' => $content
        ]);
    }

    /**
     * @param string $file_id    The file ID.
     * @param string $comment_id The comment ID.
     * @param string $reply_id   The reply ID.
     * @return bool The result of the API call.
     */
    public function delete( string $file_id, string $comment_id, string $reply_id ): bool {
        $url = str_replace(['{fileId}', '{commentId}', '{replyId}'], [$file_id, $comment_id, $reply_id], Constants::DRIVE_KIT_COMMENT_REPLY_URL);
        $result = $this->request( 'DELETE', $url, $this->auth_headers(), []);
        return $result->code == 204;
    }
}
