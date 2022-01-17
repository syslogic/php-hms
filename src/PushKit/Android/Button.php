<?php
namespace HMS\PushKit\Android;

use HMS\Core\Model;
use InvalidArgumentException;

/**
 * Class HMS PushKit Button
 *
 * @author Martin Zeitler
 */
class Button extends Model {

    protected array $mandatory_fields = ['name', 'action_type'];
    protected array $optional_fields  = ['intent_type', 'intent', 'data'];

    protected const INVALID_BUTTON_NAME = 'name cannot exceed 40 characters';
    protected const INVALID_ACTION_TYPE = 'action_type must be either 0, 1, 2, 3, 4';
    protected const INVALID_INTENT_TYPE = 'intent_type must be either 0, 1';
    protected const INVALID_INTENT_DATA = 'the maximum length is 1024 characters';

    /**
     * Button name, which cannot exceed 40 characters.
     * @var string|null $name
     */
    private string|null $name = null;

    /**
     * Button action. The options as following:
     * 0: Open the app home page
     * 1: open a custom app page
     * 2: open a specified web page
     * 3: delete a notification message
     * 4: share a notification message (only supported on Huawei devices)
     * @var int $action_type
     */
    private int $action_type = 1;

    /**
     * Method of opening a custom app page. The options are as follows:
     * 0: open the page through intent
     * 1: open the page through action
     * This parameter is mandatory when action_type is set to 1.
     * @var int $intent_type
     */
    private int $intent_type = 0;

    /**
     * When action_type is set to 1:
     * Then set this parameter to an action or the URI of the app page to be opened based on the value of intent_type.
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-Guides/andorid-basic-clickaction-0000001087554076#section20203190121410">Opening a Specified Page of an App</a>
     *
     * When action_type is set to 2:
     * Then set this parameter to the URL of the web page to be opened.
     * The URL must be an HTTPS URL. Example: https://example.com
     *
     * @var string|null $intent
     */
    private string|null $intent = null;

    /**
     * The maximum length is 1024 characters.
     * When action_type is set to 0 or 1, this parameter is used to transparently transmit data to an app after a button is tapped. The parameter is optional and its value must be key-value pairs in format of {"key1":"value1","key2":"value2",...}.
     * When action_type is set to 4, this parameter indicates content to be shared and is mandatory.
     * @var string|null $data
     */
    private string|null $data = null;

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

    static function fromArray( array $model ): Button {
        return new Button( $model );
    }

    /** Conditionally adding array items. */
    public function asArray(): array {
        $data = [];
        if ($this->name != null) {
            $data['name'] = $this->name;
        }
        if ( in_array($this->action_type, [0, 1, 2, 3, 4]) ) {
            $data['action_type'] = $this->action_type;
        }
        if ( in_array($this->intent_type, [0, 1]) ) {
            $data['intent_type'] = $this->intent_type;
        }
        if ($this->intent != null) {
            $data['intent'] = $this->intent;
        }
        if ($this->data != null) {
            $data['data'] = $this->data;
        }
        return $data;
    }

    // TODO: Implement asObject() method.
    public function asObject(): object {
        return (object) $this->asArray();
    }

    function validate(): bool {
        if ( strlen($this->name) > 40 ) {
            throw new InvalidArgumentException(self::INVALID_BUTTON_NAME);
        }
        if (! in_array($this->action_type, [0, 1, 2, 3, 4]) ) {
            throw new InvalidArgumentException(self::INVALID_ACTION_TYPE);
        }
        if (! in_array($this->intent_type, [0, 1]) ) {
            throw new InvalidArgumentException(self::INVALID_INTENT_TYPE);
        }
        if ( strlen($this->data) > 1024 ) {
            throw new InvalidArgumentException(self::INVALID_INTENT_DATA);
        }
        return true;
    }
}