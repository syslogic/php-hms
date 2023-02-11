<?php
namespace HMS\WalletKit\Model;

use HMS\Core\Model;

/**
 * Class HMS WalletKit Value Object
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/valueobject-0000001050160327">ValueObject</a>
 * @author Martin Zeitler
 */
class ValueObject extends Model {

    /** @var string $key Field ID. This ID must be unique across all pass objects. */
    private string $key;

    /** @var string $value Default field value. */
    private string $value;

    /**
     * @var string|null $label Default field label.
     * Whether label is mandatory or optional is determined each specific pass.
     */
    private ?string $label = null;

    /**
     * @var string|null $localizedValue
     * If the value is localized, this parameter should correspond to the key in Localized.
     * If this parameter is not set, the default value will be used in all languages.
     */
    private ?string $localizedValue = null;

    /**
     * @var string|null $localizedLabel
     * If the label is localized, this parameter should correspond to the key in Localized.
     * If this parameter is not set, the default value will be used in all languages.
     */
    private ?string $localizedLabel = null;

    /** @var string|null $redirectUrl Redirection link. */
    private ?string $redirectUrl = null;

    /** @var string|null $type
     * Type of the destination page of a redirection link, which will be used for urlList and imageList.
     * The options are URL, APP, and FASTAPP.
     */
    private ?string $type = null;

    public function __construct(array $config ) {
        if (! isset($config['key']) || ! isset($config['value'])) {
            throw new \InvalidArgumentException('ValueObject requires at least "key" and "value".');
        }
        $this->key = $config['key'];
        $this->value = $config['value'];
        if (isset($config['label'])) {$this->label = $config['label'];}
        if (isset($config['localizedValue'])) {$this->localizedValue = $config['localizedValue'];}
        if (isset($config['localizedLabel'])) {$this->localizedLabel = $config['localizedLabel'];}
        if (isset($config['redirectUrl'])) {$this->redirectUrl = $config['redirectUrl'];}
        if (isset($config['type'])) {$this->type = $config['type'];}
        return $this;
    }

    public static function fromArray( array $model ): ValueObject {
        return new ValueObject( $model );
    }

    public function asObject(): object {
        $data = new \stdClass();
        $data->key = $this->key;
        $data->value = $this->value;
        if ($this->label != null) {$data->label = $this->label;}
        if ($this->localizedValue != null) {$data->localizedValue = $this->localizedValue;}
        if ($this->localizedLabel != null) {$data->localizedLabel = $this->localizedLabel;}
        if ($this->redirectUrl != null) {$data->redirectUrl = $this->redirectUrl;}
        if ($this->type != null) {$data->type = $this->type;}
        return $data;
    }

    function validate(): bool {
        return true;
    }
}