<?php
namespace HMS\PushKit\WebPush;

use HMS\Core\Model;
use JetBrains\PhpStorm\Pure;

/**
 * Class HMS PushKit WebPushNotification
 *
 * @author Martin Zeitler
 */
class WebPushNotification extends Model {

    protected array $mandatory_fields = ['title', 'body'];
    protected array $optional_fields  = ['image'];

    /**
     * @var string $title
     */
    protected string|null $title = null;

    /**
     * @var string $body
     */
    protected string|null $body = null;

    /**
     * @var string|null $image
     */
    protected string|null $image = null;

    #[Pure]
    public function __construct() {

    }

    public function asObject(): object {
        return (object) [
            'title' => $this->title,
            'body'  => $this->body,
            'image' => $this->image
        ];
    }

    /** TODO: Implement fromArray() method. */
    static function fromArray( array $model ): WebPushNotification {
        return new WebPushNotification( $model );
    }

    /** TODO: Implement validate() method. */
    function validate(): bool {
        return true;
    }
}
