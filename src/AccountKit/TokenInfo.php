<?php
namespace HMS\AccountKit;

use HMS\Core\Model;

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
        return $data;
    }

    public function asObject(): object {
        return (object) [
            'client_id' => $this->client_id,
            'expire_in' => $this->expire_in,
            'union_id'  => $this->union_id,
            'open_id'   => $this->open_id,
            'scope'     => $this->scope
        ];
    }

    static function fromArray( array $model ): TokenInfo {
        return new TokenInfo( $model );
    }

    function validate(): bool {
        return true;
    }
}
