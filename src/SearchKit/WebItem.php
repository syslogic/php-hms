<?php
namespace HMS\SearchKit;

use HMS\Core\Model;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

/**
 * Class HMS SearchKit Web Item
 *
 * @author Martin Zeitler
 */
class WebItem extends Model {

    protected array $mandatory_fields = ['title', 'click_url', 'snippet'];
    protected array $optional_fields  = ['site_name', 'thumbnail'];

    /** @var string|null $title */
    private string|null $title = null;

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

    #[ArrayShape(['title' => "string"])]
    public function asArray(): array {
        return [
            'title' => $this->title
        ];
    }

    #[Pure]
    function asObject(): object {
        return (object) $this->asArray();
    }

    static function fromArray( array $model ): ContentProvider {
        return new ContentProvider( $model );
    }

    /** TODO: Implement validate() method. */
    function validate(): bool {
        return true;
    }

}