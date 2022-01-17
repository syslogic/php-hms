<?php
namespace HMS\PushKit\Apns;

use HMS\Core\Model;
use InvalidArgumentException;

/**
 * Class HMS PushKit HmsOptions
 *
 * @author Martin Zeitler
 */
class HmsOptions extends Model {

    protected array $mandatory_fields = ['target_user_type'];
    protected array $optional_fields  = [];

    protected const INVALID_TARGET_USER_TYPE = 'target_user_type must be either 1, 2, 3';

    /**
     * Target user type. The options are as follows:
     * 1: test user
     * 2: formal user
     * 3: VoIP user
     * @var int $target_user_type
     */
    private int $target_user_type = 2;

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
        if ( in_array($this->target_user_type, [1, 2, 3])) {
            $data['target_user_type'] = $this->target_user_type;
        }
        return $data;
    }

    public function asObject(): object {
        return (object) $this->asArray();
    }

    static function fromArray( array $model ): HmsOptions {
        return new HmsOptions( $model );
    }

    function validate(): bool {
        if (! in_array($this->target_user_type, [1, 2, 3])) {
            throw new InvalidArgumentException(self::INVALID_TARGET_USER_TYPE);
        }
        return true;
    }
}
