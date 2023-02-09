<?php

namespace HMS\WalletKit;

/**
 * Class HMS WalletKit Link Device Pass
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/linkdevicepass-0000001050160329">LinkDevicePass</a>
 * @author Martin Zeitler
 */
class LinkDevicePass {

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
}