<?php
namespace HMS\PushKit;

use HMS\Core\Model;
use InvalidArgumentException;

/**
 * Class HMS PushKit Notification
 *
 * @author Martin Zeitler
 */
class Notification extends Model {

    protected array $mandatory_fields = ['title', 'body'];
    protected array $optional_fields  = ['image'];

    /**
     * @var string|null $title (mandatory)
     */
    protected string|null $title = null;

    /**
     * @var string|null $body (mandatory)
     */
    protected string|null $body = null;

    /**
     * @var string|null $image (optional)
     */
    protected string|null $image = null;

    public function __construct( string|array $arg0, string|null $arg1=null, string|null $arg2=null ) {
        if ( is_array( $arg0 )) {
            $this->parse_array( $arg0 );
        } else {
            if ( is_string($arg0) ) {$this->title = $arg0;}
            if ( is_string($arg1) ) {$this->body  = $arg1;}
            if ( is_string($arg2) ) {$this->image = $arg2;}
        }
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
            'title' => $this->title,
            'body'  => $this->body,
            'image' => $this->image
        ];
    }

    static function fromArray( array $model ): Notification {
        return new Notification( $model['title'], $model['body'], $model['image'] );
    }

    function validate(): bool {
        if ( $this->title == null ) {
            throw new InvalidArgumentException( 'title must not be null' );
        }
        if ( $this->body == null ) {
            throw new InvalidArgumentException( 'body must not be null' );
        }
        return true;
    }
}
