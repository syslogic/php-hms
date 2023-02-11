<?php

namespace HMS\WalletKit\Model;

use HMS\Core\Model;

/**
 * Class HMS Wallet Object
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/def-0000001050160319">HwWalletObject</a>
 * @author Martin Zeitler
 */
class WalletObject extends Model {

    private ?string $passVersion = "1.0";
    private ?string $passTypeIdentifier = null;
    private ?string $passStyleIdentifier = null;
    private ?string $organizationName = null;
    private ?string $organizationPassId = null;
    private ?string $serialNumber = null;
    private ?Fields $fields = null;
    private ?LinkDevicePass $linkDevicePass = null;

    public function __construct( array $config ) {
        if (isset($config['passVersion'])) {$this->passVersion = $config['passVersion'];}
        if (isset($config['passTypeIdentifier'])) {$this->passTypeIdentifier = $config['passTypeIdentifier'];}
        if (isset($config['passStyleIdentifier'])) {$this->passStyleIdentifier = $config['passStyleIdentifier'];}
        if (isset($config['organizationName'])) {$this->organizationName = $config['organizationName'];}
        if (isset($config['organizationPassId'])) {$this->organizationPassId = $config['organizationPassId'];}
        if (isset($config['serialNumber'])) {$this->serialNumber = $config['serialNumber'];}
        if (isset($config['fields'])) {$this->fields = new Fields($config['fields']);}
        if (isset($config['linkDevicePass'])) {$this->linkDevicePass = new LinkDevicePass($config['linkDevicePass']);}
        return $this;
    }

    public static function fromArray( array $model ): WalletObject {
        return new WalletObject( $model );
    }

    public function asObject(): object {
        return (object) [
            'passVersion'         => $this->passVersion,
            'passTypeIdentifier'  => $this->passTypeIdentifier,
            'passStyleIdentifier' => $this->passStyleIdentifier,
            'organizationName'    => $this->organizationName,
            'organizationPassId'  => $this->organizationPassId,
            'serialNumber'        => $this->serialNumber,
            'fields'              => $this->fields->asObject(),
            'linkDevicePass'      => $this->linkDevicePass->asObject()
        ];
    }

    function validate(): bool {
        return true;
    }
}
