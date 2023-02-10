<?php
namespace HMS\WalletKit\Model;

use InvalidArgumentException;

/**
 * Class HMS WalletKit Barcode
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/barcode-0000001050158372">BarCode</a>
 * @author Martin Zeitler
 */
class BarCode {

    /** @var string $value Barcode content. */
    private string $value;

    /** @var string $text Description or numbers under a barcode. */
    private string $text;

    /** @var string $type Barcode type. Values: codabar and qrCode. */
    private string $type = 'qrCode';

    /** @var string $encoding Encoding mode, for example, UTF-8. */
    private string $encoding = 'UTF-8';

    public function __construct( array $config ) {
        return $this->fromArray( $config );
    }

    private function fromArray( array $config ): BarCode {
        if (!isset($config['value']) || !isset($config['text'])) {
            throw new InvalidArgumentException('BarCode requires at least "value" and "text".');
        } else {
            $this->value = $config['value'];
            $this->text = $config['text'];
        }
        if (isset($config['type'])) {$this->type = $config['type'];}
        if (isset($config['encoding'])) {$this->text = $config['encoding'];}
        return $this;
    }

    public function toObject(): object {
        return (object) [
            'value' => $this->value,
            'text' => $this->text,
            'type' => $this->type,
            'encoding' => $this->encoding
        ];
    }
}
