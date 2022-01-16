<?php
namespace HMS\PushKit\QuickApp;

use HMS\Core\Model;
use JetBrains\PhpStorm\Pure;

/**
 * Class HMS PushKit QuickAppConfig
 *
 * @author Martin Zeitler
 */
class QuickAppConfig extends Model {

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

    public function __construct( array $data ) {
        $this->parse_array( $data );
    }

    private function parse_array( array $data ): void {
        foreach ($data as $key => $value) {
            if ( in_array($key, $this->mandatory_fields) || in_array($key, $this->optional_fields)) {
                $this->$key = $value;
            }
        }
    }

    public function asObject(): object {
        return (object) [
            'payload'     => $this->payload,
            'hms_options' => $this->hms_options,
            'headers'     => $this->headers
        ];
    }

    static function fromArray( array $model ): QuickAppConfig {
        return new QuickAppConfig( $model );
    }

    /** TODO: Implement validate() method. */
    function validate(): bool {
        return true;
    }
}
