<?php /** @noinspection PhpUnused */
namespace HMS\DriveKit\Changes;

use HMS\DriveKit\DriveKit;
use HMS\DriveKit\Constants;

use stdClass;

/**
 * Class HMS DriveKit API: Changes
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/server-api-aboutget-0000001050151684">Changes</a>
 * @author Martin Zeitler
 */
class Changes extends DriveKit {

    /**
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/server-api-aboutget-0000001050151684">Changes</a>
     * @return bool|stdClass The result of the API call.
     */
    public function cursor( string $fields='*' ): stdClass|bool {
        return $this->request( 'GET', Constants::DRIVE_KIT_CHANGES_URL . '/getStartCursor', $this->auth_headers(), [
            'fields' => $fields
        ]);
    }

    /**
     * @return bool|stdClass The result of the API call.
     */
    public function list( string $cursor ): stdClass|bool {
        return $this->request( 'GET', Constants::DRIVE_KIT_CHANGES_URL, $this->auth_headers(), [
            'cursor' => $cursor
        ]);
    }


    /**
     * @param string $cursor       Cursor.
     * @param string $channel_id   A unique string that identifies this channel..
     * @param string $url          Address where notifications are sent for this channel.
     * @param string $user_token   A string that is sent to the target address along with each notification that is sent on this channel.
     * @param int $expiration_time Date and time when the notification channel expires, expressed as a Unix timestamp, in milliseconds.
     *                             File resources will expire within one day, while change resources will expire within one week.
     * @return bool|stdClass The result of the API call.
     */
    public function subscribe( string $cursor, string $channel_id, string $url, string $user_token, string $fields='*', int $expiration_time=0 ): stdClass|bool {
        $url = Constants::DRIVE_KIT_CHANGES_SUBSCRIBE_URL . '?cursor=' . $cursor . '&fields=' . $fields;
        $query = ['type' => 'web_hook', 'id' => $channel_id, 'url' => $url, 'userToken' => $user_token];
        if ($expiration_time != 0) {$query['expirationTime'] = $expiration_time;}
        return $this->request( 'POST', $url, $this->auth_headers(), $query);
    }
}
