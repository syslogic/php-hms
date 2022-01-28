<?php
namespace HMS\AgConnect\AuthService;

use HMS\Core\Model;
use JetBrains\PhpStorm\Pure;

/**
 * TODO: Class HMS AppGallery Connect AuthService ImportUser
 *
 * @author Martin Zeitler
 */
class ImportUser extends Model {

    protected array $mandatory_fields = [];
    protected array $optional_fields  = [];

    /**
     * @var string $defaultLang (64) Default language of an app.
     * For details, please refer to Languages.
     * @see https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-reference-langtype-0000001158245079
     */
    private string $defaultLang = "en-US";

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

    public function asArray(): array {
        return [
            'defaultLang' => $this->defaultLang
        ];
    }

    #[Pure]
    function asObject(): object {
        return (object) $this->asArray();
    }

    static function fromArray( array $model ): ImportUser {
        return new ImportUser( $model );
    }

    /** TODO: Implement validate() method. */
    function validate(): bool {
        return true;
    }
}
