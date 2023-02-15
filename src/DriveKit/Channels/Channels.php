<?php /** @noinspection PhpUnused */
namespace HMS\DriveKit\Channels;

use HMS\DriveKit\Constants;
use HMS\DriveKit\DriveKit;
use stdClass;

/**
 * Class HMS DriveKit API: Channels
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/server-api-thumbnailget-0000001050151706">Channels</a>
 * @author Martin Zeitler
 */
class Channels extends DriveKit {

    /**
     * @return bool|stdClass The result of the API call.
     */
    public function stop( ?string $quotaId, ?string $callback ): stdClass|bool {
        $query = [];
        if ($quotaId != null) {$query['quotaId'] = $quotaId;}
        if ($callback != null) {$query['callback'] = $callback;}
        return $this->request('POST', Constants::DRIVE_KIT_CHANNELS_URL, $this->auth_headers(), $query);
    }
}
