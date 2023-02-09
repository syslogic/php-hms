<?php

namespace HMS\WalletKit;

use stdClass;

/**
 * Class HMS Wallet Object
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/def-0000001050160319">HwWalletObject</a>
 * @author Martin Zeitler
 */
class HwWalletObject {
    private string $passVersion = "1.0";
    private string $passTypeIdentifier;
    private string $passStyleIdentifier;
    private string $organizationName;
    private string $organizationPassId;
    private string $serialNumber;
    private stdClass $fields;
    private LinkDevicePass $linkDevicePass;
}
