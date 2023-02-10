<?php

namespace HMS\WalletKit\Model;

/**
 * Class HMS Wallet Object
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/def-0000001050160319">HwWalletObject</a>
 * @author Martin Zeitler
 */
class WalletObject {
    private string $passVersion = "1.0";
    private string $passTypeIdentifier;
    private string $passStyleIdentifier;
    private string $organizationName;
    private string $organizationPassId;
    private string $serialNumber;
    private Fields $fields;
    private LinkDevicePass $linkDevicePass;
}
