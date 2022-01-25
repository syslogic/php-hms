<?php
namespace HMS\PushKit\Android;

use HMS\Core\Model;
use InvalidArgumentException;

/**
 * Class HMS PushKit ClickAction
 *
 * @author Martin Zeitler
 */
class ClickAction extends Model {

    protected array $mandatory_fields = ['type'];
    protected array $optional_fields  = ['intent', 'action', 'url'];

    protected const INVALID_CLICK_ACTION_TYPE = 'type must be either 1, 2, 3';
    protected const MISSING_INTENT_OR_ACTION = 'url is mandatory, when type is 1';
    protected const MISSING_URL = 'url is mandatory, when type is 2';
    protected const NON_HTTPS_URL = 'url must use https:// protocol';

    /**
     * The type of click action.
     * 1: tap to open a custom app page
     * 2: tap to open a specified URL
     * 3: tap to start the app
     * @var int $type
     */
    private int $type = 2;

    /**
     * URL to be opened. The URL must be an HTTPS URL. Example: https://example.com/image.png
     * This parameter is mandatory when type is set to 2.
     *
     * @var string|null $url
     */
    private string|null $url = null;

    /**
     * For details about intent implementation, please refer to Setting the intent Parameter.
     * When type is set to 1, you must set at least one of intent or action.
     * @var string|null $intent
     */
    private string|null $intent = null;

    /**
     * Action corresponding to the activity of the page to be opened when the custom app page is opened through the action.
     * When type is set to 1 (open a custom page), you must set at least one of intent or action.
     * @var string|null $action
     */
    private string|null $action = null;

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

    static function fromArray( array $model ): ClickAction {
        return new ClickAction( $model );
    }

    /** Conditionally adding array items. */
    public function asArray(): array {
        $data = [];
        if ( in_array($this->type, [1, 2, 3]) ) {$data['type'] = $this->type;}
        if ($this->intent != null) {$data['intent'] = $this->intent;}
        if ($this->action != null) {$data['action'] = $this->action;}
        if ($this->url    != null) {$data['url']    = $this->url;}
        return $data;
    }

    public function asObject(): object {
        return (object) $this->asArray();
    }

    function validate(): bool {
        if (! in_array($this->type, [1, 2, 3])) {
            throw new InvalidArgumentException(self::INVALID_CLICK_ACTION_TYPE);
        }
        if ($this->type == 1 && $this->action == null && $this->intent == null) {
            throw new InvalidArgumentException(self::MISSING_INTENT_OR_ACTION);
        }
        if ($this->type == 2) {
            if ($this->url == null) {
                throw new InvalidArgumentException(self::MISSING_URL);
            } else if (str_split($this->url, 8) != 'https://'){
                throw new InvalidArgumentException(self::NON_HTTPS_URL);
            }
        }
        return true;
    }
}
