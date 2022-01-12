<?php
namespace HMS\PushKit\Apns;

use HMS\PushKit\Notification;

/**
 * Class HMS PushKit ApnsNotification
 *
 * @author Martin Zeitler
 */
class ApnsNotification extends Notification {

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
