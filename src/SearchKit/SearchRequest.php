<?php
namespace HMS\SearchKit;

use HMS\Core\Model;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

/**
 * Class HMS SearchKit Search Request
 *
 * @author Martin Zeitler
 */
class SearchRequest extends Model {

    protected array $mandatory_fields = ['q', 'sregion'];
    protected array $optional_fields  = ['lang', 'pn', 'ps'];

    /** @var array $search_types  */
    private array $search_types = ['web', 'image', 'video', 'news'];

    /** @var string|null $q Search keyword (mandatory field). */
    private string|null $q = null;

    /** @var string|null $sregion Search region (mandatory field). The default value is `ww`. */
    private string|null $sregion = 'ww';

    /** @var string|null $q Search language. The default value is `en`. */
    private string|null $lang = 'en';

    /** @var int|null $pn Number of a search result page. The value ranges from 1 to 100, and the default value is 1. */
    private int|null $pn = 1;

    /** @var int|null $ps Number of search results on a page. The value ranges from 1 to 100, and the default value is 10. */
    private int|null $ps = 10;

    public function __construct( array $data ) {
        $this->parse_array( $data );
    }

    private function parse_array( array $data ): void {
        foreach ($data as $key => $value) {
            if ( in_array($key, $this->optional_fields)) {
                $this->$key = $value;
            }
        }
    }

    #[ArrayShape(['q' => "null|string", 'sregion' => "null|string", 'lang' => "null|string", 'pn' => "int|null", 'ps' => "int|null"])]
    public function asArray(): array {
        return [
            'q'       => $this->q,
            'sregion' => $this->sregion,
            'lang'    => $this->lang,
            'pn'      => $this->pn,
            'ps'      => $this->ps
        ];
    }

    #[Pure]
    function asObject(): object {
        return (object) $this->asArray();
    }

    static function fromArray( array $model ): SearchRequest {
        return new SearchRequest( $model );
    }

    /** TODO: Implement validate() method. */
    function validate(): bool {
        return true;
    }
}
