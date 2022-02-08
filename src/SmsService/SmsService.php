<?php
namespace HMS\SmsService;

/**
 * Class HMS SmsService Wrapper
 *
 * @see <a href="https://developer.huawei.com/consumer/cn/doc/development/AppGallery-connect-Guides/agc-sms-introduction-0000001072322171">SMS Service</a>
 * @author Martin Zeitler
 */
class SmsService {

    protected static string|null $business_sms_account = null;
    protected static string|null $business_sms_password = null;

    public function __construct( array|null $config = null ) {
        if (is_array( $config )) {
            if (
                isset( $config['account'] ) && !empty( $config['account'] ) &&
                isset( $config['password'] ) && !empty( $config['password'] )
            ) {

            }
        }
    }

    public function is_ready(): bool {
        return false;
    }
}
