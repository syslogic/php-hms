<?php
namespace HMS\WalletKit\Model;

use HMS\Core\Model;

/**
 * Class HMS WalletKit Barcode
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/barcode-0000001050158372">BarCode</a>
 * @author Martin Zeitler
 */
class BarCode extends Model {

    /** @var string $value Barcode content. */
    private string $value;

    /** @var string $text Description or numbers under a barcode. */
    private string $text;

    /** @var string $type Barcode type. Values: codabar and qrCode. */
    private string $type = 'qrCode';

    /** @var string $encoding Encoding mode, for example, UTF-8. */
    private string $encoding = 'UTF-8';

    public function __construct( array $config ) {
        if (! isset($config['value']) || ! isset($config['text'])) {
            throw new \InvalidArgumentException('BarCode requires at least "value" and "text".');
        } else {
            $this->value = $config['value'];
            $this->text = $config['text'];
        }
        if (isset($config['type'])) {$this->type = $config['type'];}
        if (isset($config['encoding'])) {$this->text = $config['encoding'];}
        return $this;
    }

    public static function fromArray(array $model ): BarCode {
        return new BarCode( $model );
    }

    public function asObject(): object {
        return (object) [
            'value' => $this->value,
            'text' => $this->text,
            'type' => $this->type,
            'encoding' => $this->encoding
        ];
    }

    function validate(): bool {
        if ($this->value == null) {return false;}
        if ($this->text == null) {return false;}
        if (! in_array($this->type, ['codabar', 'qrCode'])) {return false;}
        return true;
    }
}
