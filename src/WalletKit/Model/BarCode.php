<?php
namespace HMS\WalletKit\Model;

/**
 * Class HMS WalletKit Bar Code
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/barcode-0000001050158372">BarCode</a>
 * @author Martin Zeitler
 */
class BarCode {

    /** @var string $text Description or numbers under a barcode. */
    private string $text;

    /** @var string $type Barcode type. Values: codabar and qrCode. */
    private string $type = 'qrCode';

    /** @var string $value Barcode content. */
    private string $value;

    /** @var string $encoding Encoding mode, for example, UTF-8. */
    private string $encoding = 'UTF-8';
}
