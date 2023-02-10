<?php
namespace HMS\WalletKit\Model;

/**
 * Class HMS WalletKit Related Pass Ids
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/relatedpassids-0000001050158370">RelatedPassIds</a>
 * @author Martin Zeitler
 */
class RelatedPassIds {

    public function __construct( array $config ) {
        return $this->fromArray( $config );
    }

    private function fromArray( array $config ): RelatedPassIds {
        return $this;
    }

    public function toObject(): object {
        return (object) [

        ];
    }
}