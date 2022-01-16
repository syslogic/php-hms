<?php

namespace HMS\PushKit\WebPush;

use HMS\Core\Model;
use JetBrains\PhpStorm\Pure;

/**
 * Class HMS PushKit WebPushConfig
 *
 * @author Martin Zeitler
 */
class WebPushConfig extends Model {

    protected array $mandatory_fields = [];
    protected array $optional_fields  = ['headers', 'notification', 'hms_options'];

    /**
     * @var string $payload
     */
    private $payload;

    /**
     * @var string $hms_options
     */
    private $hms_options;

    /**
     * @var string $headers
     */
    private $headers;

    /**
     * @var WebPushNotification|null $notification
     */
    private $notification;

    #[Pure]
    public function __construct( array $data ) {
        $this->notification = new WebPushNotification( $data );
    }

    public function asObject(): object {
        return (object) [
            'payload'      => $this->payload,
            'hms_options'  => $this->hms_options,
            'headers'      => $this->headers,
            'notification' => $this->notification->asObject()
        ];
    }

    /** TODO: Implement fromArray() method. */
    static function fromArray( array $model ): WebPushConfig {
        return new WebPushConfig( $model );
    }

    /** TODO: Implement validate() method. */
    function validate(): bool {
        return true;
    }
}
