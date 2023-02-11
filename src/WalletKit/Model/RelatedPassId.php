<?php
namespace HMS\WalletKit\Model;

use HMS\Core\Model;

/**
 * Class HMS WalletKit Related Pass Ids
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/relatedpassids-0000001050158370">RelatedPassIds</a>
 * @author Martin Zeitler
 */
class RelatedPassId extends Model {

    /** @var string $typeId Service number (passTypeIdentifier) of a linked pass. */
    private string $typeId;

    /** @var string $id ID of a linked instance, namely, serialNumber. */
    private string $id;

    public function __construct( array $config ) {
        if (! isset($config['typeId']) || ! isset($config['id'])) {
            throw new \InvalidArgumentException('RelatedPassIds requires at least "typeId" and "id".');
        }
        $this->typeId = $config['typeId'];
        $this->id = $config['id'];
        return $this;
    }

    public static function fromArray(array $model ): RelatedPassId {
        return new RelatedPassId( $model );
    }

    public function asObject(): object {
        return (object) [
            'typeId' => $this->typeId,
            'id' => $this->id
        ];
    }

    function validate(): bool {
        return true;
    }
}