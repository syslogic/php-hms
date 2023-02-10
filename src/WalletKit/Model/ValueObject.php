<?php
namespace HMS\WalletKit\Model;

/**
 * Class HMS WalletKit Value Object
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/valueobject-0000001050160327">ValueObject</a>
 * @author Martin Zeitler
 */
class ValueObject {

    private string $key;

    private string $value;
    private ?string $label;
    private ?string $localizedValue;
    private ?string $localizedLabel;
    private ?string $redirectUrl;
    private ?string $type;

    public function __construct(array $config ) {
        return $this->fromArray( $config );
    }

    /**
     * key Field ID. This ID must be unique across all pass objects.
     * value Default field value.
     * label Default field label. Whether label is mandatory or optional is determined eacg specific pass.
     * localizedValue If the value is localized, this parameter should correspond to the key in Localized. If this parameter is not set, the default value will be used in all languages.
     * localizedLabel If the label is localized, this parameter should correspond to the key in Localized. If this parameter is not set, the default value will be used in all languages.
     * redirectUrl Redirection link,
     * type Type of the destination page of a redirection link, which will be used for urlList and imageList. The options are URL, APP, and FASTAPP.
    */
    private function fromArray( array $config ): ValueObject {
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

    public function toObject(): object {
        return (object) [
            'key' => $this->key,
            'value' => $this->value,
            'label' => $this->label,
            'localizedValue' => $this->localizedValue,
            'localizedLabel' => $this->localizedLabel,
            'redirectUrl' => $this->redirectUrl,
            'type' => $this->type
        ];
    }
}