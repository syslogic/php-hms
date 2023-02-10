<?php

namespace HMS\WalletKit\Model;

/**
 * Class HMS WalletKit Fields
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/fields-0000001050158368">Fields</a>
 * @author Martin Zeitler
 */
class Fields {

    /** @var string $countryCode Country/Region code. */
    private string $countryCode;

    /** @var string $currencyCode Currency unit. */
    private string $currencyCode;

    /** @var string $allowMultiUser Whether a pass can be claimed by multiple users. The options are true and false.
     * If this field does not exist or is set to false, a pass can be claimed by one user only.
     */
    private string $allowMultiUser = 'false';
}