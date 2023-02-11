<?php

namespace HMS\WalletKit\WalletObject;

use HMS\Core\Model;

/**
 * Class HMS WalletKit Link Device Pass
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/linkdevicepass-0000001050160329">LinkDevicePass</a>
 * @author Martin Zeitler
 */
class LinkDevicePass extends Model {

    /** @var string $webServiceURL NFC API URL that you provided. */
    private string $webServiceURL;

    /** @var string $token Token, which is used to download the DevicePass package from your server. */
    private string $token;

    /** @var string $serialNumber Unique NFC pass ID that you defined. */
    private string $serialNumber;

    /** @var string $passVersion DevicePass package version. */
    private string $passVersion;

    /**
     * @var string $spPublickey
     * Public key that you have provided in AppGallery Connect.
     * NFC pass data will not be sent to the Huawei server.
     * Therefore, the device needs to verify the signature using this parameter.
     */
    private string $spPublickey;

    /**
     * NFC pass type, with a fixed value of 1, indicating that NFC capabilities are enabled.
     * If the value is not 1, the NFC capabilities will be unavailable for a pass instance.
     */
    private string $nfcType = '1'; // NFC enabled.

    public function __construct( array $config ) {
        if (isset($config['webServiceURL'])) {$this->webServiceURL = $config['webServiceURL'];}
        if (isset($config['token'])) {$this->token = $config['token'];}
        if (isset($config['serialNumber'])) {$this->serialNumber = $config['serialNumber'];}
        if (isset($config['passVersion'])) {$this->passVersion = $config['passVersion'];}
        if (isset($config['spPublickey'])) {$this->token = $config['spPublickey'];}
        return $this;
    }

    public static function fromArray(array $model ): LinkDevicePass {
        return new LinkDevicePass( $model );
    }

    public function asObject(): object {
        return (object) [
            'webServiceURL' => $this->webServiceURL,
            'token' => $this->token,
            'serialNumber' => $this->serialNumber,
            'spPublickey' => $this->spPublickey,
            'nfcType' => $this->nfcType
        ];
    }

    function validate(): bool {
        return true;
    }
}