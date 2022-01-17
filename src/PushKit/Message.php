<?php
namespace HMS\PushKit;

use HMS\Core\Model;

/**
 * Class HMS PushKit Message
 *
 * @author Martin Zeitler
 */
class Message extends Model {

    protected array $mandatory_fields = [];
    protected array $optional_fields = ['data', 'notification', 'android', 'apns', 'webpush', 'token', 'topic', 'condition'];

    /**
     * Custom message payload.
     * The value can be a JSON string for notification messages, and can be a common string or JSON string for data messages.
     * Example: "your data" or "{'param1':'value1','param2':'value2'}"
     * - If the message body contains `message.data` and does not contain `message.notification` or `message.android.notification`, the message is a data message.
     * - If a data message is sent to a web app, the `orignData` field in the received data message indicates the content of the data message.
     * @var string $data
     */
    protected string|null $data = null;

    /**
     * Notification message content.
     * For details about the parameters, please refer to the definition in Notification Structure.
     * @var object|null $notification
     */
    protected object|null $notification = null;

    /**
     * Android message push control.
     *
     * For details about the parameters, please refer to the definition in AndroidConfig Structure.
     * This parameter is mandatory for Android notification messages.
     * @var object|null $android
     */
    protected object|null $android = null;

    /**
     * iOS message push control.
     * For details about the parameters, please refer to the definition in ApnsConfig Structure.
     * This parameter is mandatory for iOS messages.
     * @var object|null $apns
     */
    protected object|null $apns = null;

    /**
     * Web app message push control.
     * For details about the parameters, please refer to the definition in WebPushConfig Structure.
     * This parameter is mandatory for web app notification messages.
     * @var object|null $webpush
     */
    protected object|null $webpush = null;

    /**
     * Push token of the target user of a message.
     * You must and only can set one of token, topic, and condition.
     * Example: "token":["token1","token2"]
     * @var array|null $token
     */
    protected array|null $token = null;

    /**
     * Topic subscribed by the target user of a message.
     * You must and can only set one of token, topic, and condition.
     * Currently, this parameter applies only to Android apps.
     * @var string|null $topic
     */
    protected string|null $topic = null;

    /**
     * Condition (topic combination expression) for sending a message to the target user.
     * You must and can only set one of token, topic, and condition.
     * Currently, this parameter applies only to Android apps.
     * @var string|null $condition
     */
    protected string|null $condition = null;

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

    static function fromArray( array $model ): Message {
        return new Message( $model );
    }

    /** Conditionally adding array items. */
    public function asArray(): array {
        $data = [];
        return $data;
    }

    public function asObject(): object {
        return (object) $this->asArray();
    }

    // TODO: Implement validate() method.
    function validate(): bool {
        return true;
    }
}
