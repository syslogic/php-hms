<?php
namespace HMS\PushKit\WebPush;

use HMS\Core\Model;

/**
 * Class HMS PushKit WebNotification
 *
 * @author Martin Zeitler
 */
class WebNotification extends Model {

    protected array $mandatory_fields = ['title', 'body'];
    protected array $optional_fields  = ['image'];

    /**
     * Title of a web app notification message.
     * If the title parameter is set, the value of the `message.notification.title` field is overwritten.
     * Before a message is sent, you must set at least one of `title` or `message.notification.title`.
     * @var string|null $title
     */
    protected string|null $title = null;

    /**
     * Body of a web app notification message.
     * If the body parameter is set, the value of the `message.notification.body` field is overwritten.
     * Before a message is sent, you must set at least one of `body` or `message.notification.body`.
     * @var string|null $body
     */
    protected string|null $body = null;

    /**
     * Small icon URL.
     * @var string|null $icon
     */
    protected string|null $icon = null;

    /**
     * Large image URL.
     * @var string|null $image
     */
    protected string|null $image = null;

    /**
     * Language.
     * @var string|null $lang
     */
    protected string|null $lang = null;

    /**
     * Notification message group tag.
     * Multiple same tags are collapsed and the latest one is displayed.
     * This function is used only for mobile phone browsers.
     * @var string|null $tag
     */
    protected string|null $tag = null;

    /**
     * Browser icon URL, which only applies to mobile phone browsers
     * and is used to replace the default browser icon.
     * @var string|null $badge
     */
    protected string|null $badge = null;

    /**
     * Text direction. The options are as follows:
     * auto: from left to right (default value)
     * ltr: from left to right
     * rtl: from right to left
     * @var string|null $dir
     */
    protected string $dir = 'auto';

    /**
     * Vibration interval, in milliseconds.
     * Example: [100,200,300]
     * @var array $vibrate
     */
    protected array $vibrate = [];

    /**
     * Message reminding flag.
     * @var bool $renotify
     */
    protected bool $renotify = false;

    /**
     * Indicates that notification messages should remain active until a user taps or closes them.
     * @var bool $require_interaction
     */
    protected bool $require_interaction = false;

    /**
     * Message sound-free and vibration-free reminding flag.
     * @var bool $silent
     */
    protected bool $silent = false;

    /**
     * Standard Unix timestamp.
     * @var int $timestamp
     */
    protected int $timestamp = 0;

    /**
     * Standard Unix timestamp.
     * @var WebAction[] $actions
     */
    protected array $actions;

    /** Constructor */
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

    public function asObject(): object {
        return (object) [
            'title' => $this->title,
            'body'  => $this->body,
            'image' => $this->image
        ];
    }

    /** TODO: Implement fromArray() method. */
    static function fromArray( array $model ): WebNotification {
        return new WebNotification( $model );
    }

    /** TODO: Implement validate() method. */
    function validate(): bool {
        return true;
    }
}
