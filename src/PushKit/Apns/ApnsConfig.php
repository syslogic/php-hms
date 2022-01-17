<?php
namespace HMS\PushKit\Apns;

use HMS\Core\Model;

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

    public function __construct( array $data ) {
        $this->parse_array( $data );
    }

    private function parse_array( array $data ): void {
        foreach ($data as $key => $value) {
            if ( in_array($key, array_merge($this->mandatory_fields, $this->optional_fields)) ) {
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

    /** TODO: Implement fromArray() method. */
    static function fromArray( array $model ): ApnsConfig {

    }

    /** TODO: Implement validate() method. */
    function validate(): bool {
        return true;
    }
}
