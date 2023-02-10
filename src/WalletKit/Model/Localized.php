<?php
namespace HMS\WalletKit\Model;

/**
 * Class HMS WalletKit Localized
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/localized-0000001050158374">Localized</a>
 * @author Martin Zeitler
 */
class Localized {

    public function __construct( array $config ) {
        return $this->fromArray( $config );
    }

    private function fromArray( array $config ): Localized {
        return $this;
    }

    public function toObject(): object {
        return (object) [

        ];
    }
}