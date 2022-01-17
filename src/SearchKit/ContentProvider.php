<?php
namespace HMS\SearchKit;

use HMS\Core\Model;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

/**
 * Class HMS SearchKit Generic Content Provider
 *
 * @author Martin Zeitler
 */
class ContentProvider extends Model {

    protected array $mandatory_fields = ['site_name'];
    protected array $optional_fields  = ['logo'];

    /** @var string|null $site_name Name of the web page that provides the news or video. */
    private string|null $site_name = null;

    /** @var string|null $logo Icon of the web page that provides the news, which is encoded using Base64. */
    private string|null $logo = null;

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

    #[ArrayShape(['site_name' => "string", 'logo' => "null|string"])]
    public function asArray(): array {
        return [
            'site_name' => $this->site_name,
            'logo'      => $this->logo
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
