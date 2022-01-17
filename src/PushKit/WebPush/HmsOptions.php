<?php
namespace HMS\PushKit\WebPush;

use HMS\Core\Model;

/**
 * Class HMS PushKit WebPushConfig.HmsOptions
 *
 * @author Martin Zeitler
 */
class HmsOptions extends Model {

    protected array $mandatory_fields = [];
    protected array $optional_fields  = ['link'];

    /**
     * Default URI for redirection when no action is performed.
     *
     * @var string|null $link
     */
    private string|null $link = null;

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
        if ( $this->link != null ) {
            $data['link'] = $this->link;
        }
        return $data;
    }

    public function asObject(): object {
        return (object) $this->asArray();
    }

    static function fromArray( array $model ): HmsOptions {
        return new HmsOptions( $model );
    }

    function validate(): bool {
        return true;
    }
}
