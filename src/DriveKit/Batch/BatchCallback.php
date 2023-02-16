<?php /** @noinspection PhpUnused */
namespace HMS\DriveKit\Batch;

use HMS\DriveKit\Constants;
use HMS\DriveKit\DriveKit;
use stdClass;

/**
 * Class HMS DriveKit API: Batch Callback
 *
 * @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/server-api-batchcallback-0000001050727110 BatchCallback
 * @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/server-api-batchcallback-0000001050727110#section1543214154012 Call Example
 * @author Martin Zeitler
 */
class BatchCallback extends DriveKit {

    /**
     * Request: Content-Type: multipart/mixed;boundry=XXX
     *
     * @return bool|stdClass The result of the API call.
     */
    public function list( string $fileId ): stdClass|bool {
        $url = str_replace('{fileId}', $fileId, Constants::DRIVE_KIT_BATCH_URL);
        return false;
    }
}
