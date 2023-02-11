<?php
namespace HMS\WalletKit;

/**
 * Interface HMS Wallet Pass
 *
 * @author Martin Zeitler
 */
interface IWalletPass {
    public function create( array $model ): bool|\stdClass;
    public function query( string $model_id ): bool|\stdClass;
    public function update( string $model_id, array $model, $partial=false ): bool|\stdClass;
    public function add_message( string $model_id, array $messages ): bool|\stdClass;
}
