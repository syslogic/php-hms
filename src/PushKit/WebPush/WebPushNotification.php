<?php
namespace HMS\PushKit\WebPush;

use HMS\PushKit\Notification;

/**
 * Class HMS PushKit WebPushNotification
 *
 * @author Martin Zeitler
 */
class WebPushNotification extends Notification {

    protected array $mandatory_fields = ['title', 'body'];
    protected array $optional_fields  = ['image'];

    public function __construct( string $title, string $body, string|null $image=null ) {
        parent::__construct( $title, $body, $image );
    }

    public function asObject(): object {
        return (object) [
            'title' => $this->title,
            'body' => $this->body,
            'image' => $this->image
        ];
    }
}
