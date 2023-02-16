<?php
namespace HMS\WalletKit\WalletObject;

use HMS\Core\Model;

/**
 * Class HMS WalletKit Localized
 *
 * @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/localized-0000001050158374 Localized
 * @author Martin Zeitler
 */
class Localized extends Model {

    /**
     * @var string|null $key Field ID.
     * The key value must be unique across all languages of the same type.
     * This key corresponds to localizedValue or localizedLabel in ValueObject.
     */
    private ?string $key;

    /** @var string|null $value Language type value. */
    private ?string $value;

    /** @var string|null $language Language type. */
    private ?string $language;

    public function __construct( array $config ) {
        if (isset($config['key'])) {$this->key = $config['key'];}
        if (isset($config['value'])) {$this->value = $config['value'];}
        if (isset($config['language'])) {$this->language = $config['language'];}
        return $this;
    }

    public static function fromArray(array $model ): Localized {
        return new Localized( $model );
    }

    public function asObject(): object {
        return (object) [
            'key' => $this->key,
            'value' => $this->value,
            'language' => $this->language
        ];
    }

    function validate(): bool {
        return true;
    }
}