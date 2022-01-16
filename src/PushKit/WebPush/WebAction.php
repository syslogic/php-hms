<?php
namespace HMS\PushKit\WebPush;

use HMS\Core\Model;
use JetBrains\PhpStorm\Pure;

/**
 * Class HMS PushKit WebAction
 *
 * @author Martin Zeitler
 */
class WebAction extends Model {

    protected array $mandatory_fields = [];
    protected array $optional_fields  = ['action', 'icon', 'title'];

    /**
     * Action name.
     * @var string|null $action
     */
    private string|null $action = null;

    /**
     * URL for the button icon of an action.
     * @var string|null $icon
     */
    private string|null $icon = null;

    /**
     * Title of an action.
     * @var string|null $icon
     */
    private string|null $title = null;

    public function __construct( array $data ) {
        $this->parse_array( $data );
    }

    private function parse_array( array $data ): void {
        foreach ($data as $key => $value) {
            if ( in_array($key, $this->mandatory_fields) || in_array($key, $this->optional_fields)) {
                $this->$key = $value;
            }
        }
    }

    /** Conditionally adding array items. */
    public function asArray(): array {
        $data = [];
        if ( $this->action != null ) {$data['action'] = $this->action;}
        if ( $this->icon   != null ) {$data['icon']   = $this->icon;}
        if ( $this->title  != null ) {$data['title']  = $this->title;}
        return $data;
    }

    public function asObject(): object {
        return (object) $this->asArray();
    }

    static function fromArray( array $model ): WebAction {
        return new WebAction( $model );
    }

    function validate(): bool {
        return true;
    }
}
