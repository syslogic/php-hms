<?php
namespace HMS\PushKit\Android;

use HMS\Core\Model;

/**
 * Class HMS PushKit AndroidConfig
 *
 * @author Martin Zeitler
 */
class AndroidConfig extends Model {

    protected array $mandatory_fields = [];
    protected array $optional_fields  = ['collapse_key', 'ttl', 'bi_tag', 'receipt_id', 'fast_app_target', 'data', 'notification'];

    /**
     * @var int $collapse_key
     */
    private int $collapse_key = -1;

    /**
     * @var string|null $ttl
     */
    private string|null $ttl = '86400s';

    /**
     * @var string|null $bi_tag
     */
    private string|null $bi_tag = null;

    /**
     * @var string|null $receipt_id
     */
    private string|null $receipt_id = null;

    /**
     * @var int $fast_app_target
     */
    private int $fast_app_target = 2;

    /**
     * If the message body contains `message.data` and does not contain `message.notification` or `message.android.notification`, the message is a data message.
     * @var string|null $data
     */
    private string|null $data = null;

    /**
     * @var AndroidNotification|null $notification
     */
    private AndroidNotification|null $notification = null;

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

    /** Conditionally adding array items. */
    public function asArray(): array {
        $data = [];
        if ($this->collapse_key    != null) {$data['collapse_key']    = $this->collapse_key;}
        if ($this->ttl             != null) {$data['ttl']             = $this->ttl;}
        if ($this->bi_tag          != null) {$data['bi_tag']          = $this->bi_tag;}
        if ($this->receipt_id      != null) {$data['receipt_id']      = $this->receipt_id;}
        if ($this->fast_app_target != null) {$data['fast_app_target'] = $this->fast_app_target;}
        if ($this->data            != null) {$data['data']            = $this->data;}
        if ($this->notification    != null) {$data['notification']    = $this->notification->asObject();}
        return $data;
    }

    public function asObject(): object {
        return (object) $this->asArray();
    }

    static function fromArray( array $model ): AndroidConfig {
        return new AndroidConfig( $model );
    }

    /** TODO: Implement validate() method. */
    function validate(): bool {
        return true;
    }
}
