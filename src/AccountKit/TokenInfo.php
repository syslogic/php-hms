<?php
namespace HMS\AccountKit;

use HMS\Core\Model;

/**
 * Class HMS AccountKit TokenInfo
 *
 * @author Martin Zeitler
 */
class TokenInfo extends Model {

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

    /** Conditionally adding array items. */
    public function asArray(): array {
        $data = [];
        return $data;
    }

    public function asObject(): object {
        return (object) [];
    }

    static function fromArray( array $model ): UserInfo {
        return new UserInfo( $model );
    }

    function validate(): bool {
        return true;
    }
}
