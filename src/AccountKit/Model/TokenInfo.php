<?php
namespace HMS\AccountKit\Model;

use HMS\Core\Model;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

/**
 * Class HMS AccountKit TokenInfo
 *
 * @author Martin Zeitler
 */
class TokenInfo extends Model {

    protected array $mandatory_fields = ['client_id', 'expire_in'];
    protected array $optional_fields  = ['union_id', 'open_id', 'scope'];

    /**
     * OAuth 2.0 client ID.
     *
     * @var string|null $client_id
     */
    private string|null $client_id = null;

    /**
     * Access token validity period, in seconds.
     * The default value is 3600 seconds.
     *
     * @var int $expire_in
     */
    private int $expire_in = 3600;

    /**
     * UnionID of a user, which is generated after the user ID and app developer ID are concatenated and signed.
     *
     * @var string|null $union_id
     */
    private string|null $union_id = null;

    /**
     * OpenID of a user, which is generated after the user ID and app ID are concatenated and encrypted.
     * This parameter is returned only when the access token is at the user level and the input parameter `open_id` is set to `OPENID`.
     *
     * @var string|null $open_id
     */
    private string|null $open_id = null;

    /**
     * User authorization scope list.
     * This parameter is returned only when the access token is at the user level.
     *
     * @var string|null $scope
     */
    private string|null $scope = null;

    public function __construct( object|array $data ) {
        if ( is_object( $data ) ) {
            $this->parse_array((array) $data );
        } else if ( is_array( $data ) ) {
            $this->parse_array( $data );
        }
    }

    private function parse_array( array $data ): void {
        foreach ($data as $key => $value) {
            if ( in_array($key, array_merge($this->mandatory_fields, $this->optional_fields)) ) {
                $this->$key = $value;
            }
        }
    }

    /** Conditionally adding array items. */
    #[ArrayShape(['client_id' => "null|string", 'expire_in' => "int", 'union_id' => "null|string", 'open_id' => "null|string", 'scope' => "null|string"])]
    public function asArray(): array {
        return [
            'client_id' => $this->client_id,
            'expire_in' => $this->expire_in,
            'union_id'  => $this->union_id,
            'open_id'   => $this->open_id,
            'scope'     => $this->scope
        ];
    }

    #[Pure]
    function asObject(): object {
        return (object) $this->asArray();
    }

    static function fromArray( array $model ): TokenInfo {
        return new TokenInfo( $model );
    }

    function validate(): bool {
        return true;
    }
}
