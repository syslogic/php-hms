<?php
namespace HMS\WalletKit;

use HMS\Core\Wrapper;

/**
 * Class HMS WalletKit Wrapper
 *
 * @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/create-model-0000001050158460 WalletKit
 * @author Martin Zeitler
 */
class WalletCallback extends Wrapper {
    public function __construct( array|string $config ) {
        parent::__construct( $config );
        $this->post_init();
    }

    /** Unset properties irrelevant to the child class. */
    protected function post_init(): void {
        unset($this->api_key, $this->api_signature);
    }

    /** @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/callback-0000001050160427 Callback Notification API of Wallet Pass Events */
    public function onWalletPassEvent( string $payload ): void {

    }

    /** @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/callback-0000001050160427 Callback Notification API of NFC Events */
    public function onNfcEvent( string $payload ): void {

    }
}
