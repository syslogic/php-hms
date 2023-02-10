<?php
namespace HMS\WalletKit\Model;

/**
 * Class HMS WalletKit Status
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/status-0000001050160323">Status</a>
 * @author Martin Zeitler
 */
class Status {

    public function __construct( array $config ) {
        return $this->fromArray( $config );
    }

    private function fromArray( array $config ): Status {
        return $this;
    }

    public function toObject(): object {
        return (object) [

        ];
    }
}