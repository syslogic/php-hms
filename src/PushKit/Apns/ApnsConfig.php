<?php
namespace HMS\PushKit\Apns;

use HMS\Core\Model;
use JetBrains\PhpStorm\Pure;

/**
 * Class HMS PushKit ApnsConfig
 *
 * @author Martin Zeitler
 */
class ApnsConfig extends Model {

    protected array $mandatory_fields = ['payload', 'hms_options'];
    protected array $optional_fields  = ['headers'];

    /**
     * @var string $payload
     */
    private $payload;

    /**
     * @var string $hms_options
     */
    private $hms_options;

    /**
     * @var string $headers
     */
    private $headers;

    #[Pure]
    public function __construct( array $data ) {

    }

    public function asObject(): object {
        return (object) [
            'payload'     => $this->payload,
            'hms_options' => $this->hms_options,
            'headers'     => $this->headers
        ];
    }

    /** TODO: Implement fromArray() method. */
    static function fromArray( array $model ): ApnsConfig {

    }

    /** TODO: Implement validate() method. */
    function validate(): bool {
        return true;
    }
}
