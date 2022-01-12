<?php
namespace HMS\PushKit\QuickApp;

use HMS\PushKit\Notification;

/**
 * Class HMS PushKit QuickAppNotification
 *
 * @author Martin Zeitler
 */
class QuickAppNotification extends Notification {

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
