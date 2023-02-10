<?php
namespace HMS\WalletKit\Model;

/**
 * Class HMS WalletKit Location List
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/locationlist-0000001050160325">LocationList</a>
 * @author Martin Zeitler
 */
class LocationList {

    public function __construct( array $config ) {
        return $this->fromArray( $config );
    }

    private function fromArray( array $config ): LocationList {
        return $this;
    }

    public function toObject(): object {
        return (object) [

        ];
    }
}