<?php
namespace HMS\PushKit\Android;

use HMS\Core\Model;

/**
 * Class HMS PushKit Color
 *
 * @author Martin Zeitler
 */
class Color extends Model {


    protected array $mandatory_fields = [''];
    protected array $optional_fields  = [''];

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

    static function fromArray( array $model ): Color {
        return new Color( $model );
    }

    /** Conditionally adding array items. */
    public function asArray(): array {
        $data = [];
        return $data;
    }

    public function asObject(): object {
        return (object) $this->asArray();
    }

    function validate(): bool {
        return true;
    }
}
