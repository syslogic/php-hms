<?php
namespace HMS\PushKit\WebPush;

use HMS\Core\Model;
use JetBrains\PhpStorm\Pure;

/**
 * Class HMS PushKit Headers
 *
 * @author Martin Zeitler
 */
class Headers extends Model {

    protected array $mandatory_fields = [];
    protected array $optional_fields  = ['ttl', 'topic'];

    /**
     * Message cache time, in seconds, for example, 20, 20s, or 20S.
     * @var int|string|null $ttl
     */
    private int|string|null $ttl = null;


    /**
     * Message ID, which can be used to overwrite undelivered messages.
     * @var string|null $topic
     */
    private string|null $topic = null;

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

    /** Conditionally adding array items. */
    public function asArray(): array {
        $data = [];
        if ( $this->ttl   != null ) {$data['ttl']   = $this->ttl;}
        if ( $this->topic != null ) {$data['topic'] = $this->topic;}
        return $data;
    }

    public function asObject(): object {
        return (object) $this->asArray();
    }

    #[Pure]
    static function fromArray( array $model ): Headers {
        return new Headers( $model );
    }

    function validate(): bool {
        return true;
    }
}
