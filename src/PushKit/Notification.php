<?php
namespace HMS\PushKit;

use HMS\Core\Model;
use HMS\PushKit\WebPush\WebPushNotification;
use JetBrains\PhpStorm\Pure;

/**
 * Class HMS PushKit Notification
 *
 * @author Martin Zeitler
 */
class Notification extends Model {

    protected array $mandatory_fields = ['title', 'body'];
    protected array $optional_fields  = ['image'];

    /** @var string $title (mandatory) */
    protected string|null $title = null;

    /** @var string $body (mandatory) */
    protected string|null $body = null;

    /** @var string|null $image (optional) */
    protected string|null $image = null;

    private function parse_array( array $data ): void {
        foreach ($data as $key => $value) {
            if ( in_array($key, $this->mandatory_fields) || in_array($key, $this->optional_fields)) {
                $this->$key = $value;
            }
        }
    }

    public function __construct( string|array $arg0, string|null $arg1=null, string|null $arg2=null ) {
        if ( is_array( $arg0 )) {
            $this->parse_array( $arg0 );
        } else {
            if ( is_string($arg0) ) {$this->title = $arg0;}
            if ( is_string($arg1) ) {$this->body  = $arg1;}
            if ( is_string($arg2) ) {$this->image = $arg2;}
        }
    }

    public function asObject(): object {
        return (object) [
            'title' => $this->title,
            'body'  => $this->body,
            'image' => $this->image
        ];
    }

    /** TODO: Implement fromArray() method. */
    static function fromArray( array $model ): Notification {
        return new Notification( $model['title'], $model['body'], $model['image'] );
    }

    /** TODO: Implement validate() method. */
    function validate(): bool {
        return true;
    }
}
