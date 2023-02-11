<?php

namespace HMS\WalletKit\WalletObject;

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
        $data = new \stdClass();
        if ($this->passVersion != null) {$data->passVersion = $this->passVersion;}
        if ($this->passTypeIdentifier != null) {$data->passTypeIdentifier = $this->passTypeIdentifier;}
        if ($this->passStyleIdentifier != null) {$data->passStyleIdentifier = $this->passStyleIdentifier;}
        if ($this->organizationName != null) {$data->organizationName = $this->organizationName;}
        if ($this->organizationPassId != null) {$data->organizationPassId = $this->organizationPassId;}
        if ($this->serialNumber != null) {$data->label = $this->serialNumber;}
        if ($this->fields != null) {$data->fields = $this->fields->asObject();}
        if ($this->linkDevicePass != null) {$data->linkDevicePass = $this->linkDevicePass->asObject();}
        return $data;
    }

    function validate(): bool {
        return true;
    }
}
