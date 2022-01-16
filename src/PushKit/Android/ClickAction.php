<?php

namespace HMS\PushKit\Android;

use HMS\Core\Model;
use JetBrains\PhpStorm\Pure;

class ClickAction extends Model {

    protected array $mandatory_fields = ['type'];
    protected array $optional_fields  = ['intent', 'action', 'url'];

    #[Pure]
    public function __construct( array $data ) {
        $this->parse_array( $data );
    }

    /**
     * @var int $type
     */
    private int $type = 2; // 1, 2, 3

    /**
     * @var int $url
     */
    private string|null $url = null;

    /**
     * @var int $intent
     */
    private string|null $intent = null;

    /**
     * @var int $action
     */
    private string|null $action = null;

    // TODO: Implement fromArray() method.
    #[Pure]
    static function fromArray( array $model ): ClickAction {
        return new ClickAction( $model );
    }

    /** Conditionally adding array items. */
    public function asArray(): array {
        $data = [];
        if ($this->type > 0) {$data['type'] = $this->type;}
        if ($this->intent != null) {$data['intent'] = $this->intent;}
        if ($this->action != null) {$data['action'] = $this->action;}
        if ($this->url != null) {$data['url'] = $this->url;}
        return $data;
    }

    // TODO: Implement asObject() method.
    public function asObject(): object {
        return (object) $this->asArray();
    }

    // TODO: Implement validate() method.
    function validate(): bool {

    }
}