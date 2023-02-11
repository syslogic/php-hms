<?php
namespace HMS\WalletKit;

/**
 * Interface HMS Wallet Pass
 *
 * @author Martin Zeitler
 */
interface IWalletPass {
    public function create_model( array $model ): bool|\stdClass;
    public function query_model( string $model_id ): bool|\stdClass;
    public function update_model( string $model_id, array $model, $partial=false ): bool|\stdClass;
    public function add_message_to_model( string $model_id, array $messages ): bool|\stdClass;
    public function create_instance( array $instance ): bool|\stdClass;
    public function query_instance( string $instance_id ): bool|\stdClass;
    public function update_instance( string $instance_id, array $instance, $partial=false ): bool|\stdClass;
    public function add_message_to_instance( string $instance_id, array $messages ): bool|\stdClass;
}
