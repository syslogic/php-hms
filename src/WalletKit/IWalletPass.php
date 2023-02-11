<?php

namespace HMS\WalletKit;

use HMS\WalletKit\Model\WalletObject;
/**
 * Interface HMS Wallet Pass
 *
 * @author Martin Zeitler
 */
interface IWalletPass {
    public function create_model(WalletObject $value): bool|\stdClass;
    public function query_model(string $model_id): bool|\stdClass;
}