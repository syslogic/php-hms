<?php
namespace HMS\PushKit;

use HMS\Core\Model;

/**
 * Class HMS PushKit Notification
 *
 * @author Martin Zeitler
 */
class Notification extends Model {

    protected array $mandatory_fields = ['title', 'body'];
    protected array $optional_fields  = ['image'];

    /** @var string $title (mandatory) */
    protected string $title;

    /** @var string $body (mandatory) */
    protected string $body;

    /** @var string|null $image (optional) */
    protected string|null $image;

    public function __construct( string $title, string $body, string|null $image=null ) {
        $this->title = $title;
        $this->body = $body;
        $this->image = $image;
    }

    public function asObject(): object {
        return (object) [
            'title' => $this->title,
            'body'  => $this->body,
            'image' => $this->image
        ];
    }

    /** TODO: Implement validate() method. */
    function validate(): bool {
        return true;
    }
}
