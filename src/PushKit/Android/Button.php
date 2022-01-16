<?php
namespace HMS\PushKit\Android;

use HMS\Core\Model;
use JetBrains\PhpStorm\Pure;
use stdClass;

/**
 * Class HMS PushKit Button
 *
 * @author Martin Zeitler
 */
class Button extends Model {

    #[Pure]
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

    // TODO: Implement fromArray() method.
    static function fromArray( array $model ): Button {
        return new Button( $model );
    }

    // TODO: Implement asObject() method.
    function asObject(): object  {

        return new stdClass();
    }

    // TODO: Implement validate() method.
    function validate(): bool {

        return true;
    }
}