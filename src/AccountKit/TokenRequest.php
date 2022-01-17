<?php
namespace HMS\AccountKit;

use HMS\Core\Model;
use InvalidArgumentException;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

/**
 * Class HMS AccountKit Token Request
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/server-error-codes-0000001062371380">Error Codes</a>
 * @author Martin Zeitler
 */
class TokenRequest extends Model {

    protected array $mandatory_fields = ['grant_type', 'client_id', 'client_secret'];
    protected array $optional_fields  = ['code', 'redirect_url', 'refresh_token'];

    protected const INVALID_GRANT_TYPE    = 'grant_type must be one of: client_credentials, authorization_code, refresh_token';
    protected const INVALID_CLIENT_ID     = 'client_id is mandatory';
    protected const INVALID_CLIENT_SECRET = 'client_secret is mandatory';
    protected const INVALID_AUTH_CODE     = 'code is mandatory for grant_type authorization_code';
    protected const INVALID_REDIRECT_URI  = 'redirect_uri is mandatory for grant_type authorization_code';
    protected const INVALID_REFRESH_TOKEN = 'refresh_token is mandatory for grant_type refresh_token';

    /** @var array $grant_types `client_credentials` isn't documented, but apparently working. */
    private array $grant_types = ['client_credentials', 'authorization_code', 'refresh_token'];

    /**
     * OAuth 2.0 Request type (mandatory).
     *
     * The options are as follows:
     * - `client_credentials`: Use client_id and client_secret to obtain an access token.
     * - `authorization_code`: Use an authorization code to obtain an access token, a refresh token, or an ID token.
     * - `refresh_token`: Refresh an access token.
     * @var string $grant_type
     */
    private string $grant_type = 'client_credentials';

    /**
     * OAuth 2.0 client ID (mandatory field).
     *
     * An unique identifier allocated by the HUAWEI Developers website to an app after it is created.
     * @see <a href="https://developer.huawei.com/consumer/en/doc/distribution/app/agc-help-appinfo-0000001100014694">Viewing App Basic Information</a>
     * @var int|null $client_id
     */
    private int|null $client_id = null;

    /**
     * OAuth 2.0 client secret (mandatory field).
     *
     * A public key allocated by the HUAWEI Developers website to an app after it is created.
     * @see <a href="https://developer.huawei.com/consumer/en/doc/distribution/app/agc-help-appinfo-0000001100014694">Viewing App Basic Information</a>
     * @var string|null $client_secret
     */
    private string|null $client_secret = null;

    /**
     * This parameter is mandatory when grant_type is set to `authorization_code`.
     *
     * @var string|null $code Set this parameter to the authorization code obtained during the authorization.
     */
    private string|null $code = null;

    /**
     * This parameter is mandatory when grant_type is set to `authorization_code`.
     *
     * @var string|null $redirect_uri Callback address configured in the request for obtaining the
     *                                authorization code, when grant_type is set to `authorization_code`.
     */
    private string|null $redirect_uri = null;

    /**
     * This parameter is mandatory when grant_type is set to `refresh_token`.
     *
     * @var string|null $refresh_token Set this parameter to the refresh token obtained using the authorization code.
     */
    private string|null $refresh_token = null;

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

    #[ArrayShape(['grant_type' => "string", 'client_id' => "int|null", 'client_secret' => "null|string", 'code' => "null|string", 'redirect_uri' => "null|string", 'refresh_token' => "null|string"])]
    public function asArray(): array {
        return [
            'grant_type'    => $this->grant_type,
            'client_id'     => $this->client_id,
            'client_secret' => $this->client_secret,
            'code'          => $this->code,
            'redirect_uri'  => $this->redirect_uri,
            'refresh_token' => $this->refresh_token
        ];
    }

    #[Pure]
    function asObject(): object {
        return (object) $this->asArray();
    }

    static function fromArray( array $model ): TokenRequest {
        return new TokenRequest( $model );
    }

    /** TODO: Implement validate() method. */
    function validate(): bool {
        if (! in_array($this->grant_type, $this->grant_types) ) {
            throw new InvalidArgumentException(self::INVALID_GRANT_TYPE);
        }
        if ( $this->client_id == null ) {
            throw new InvalidArgumentException(self::INVALID_CLIENT_ID);
        }
        if ( $this->client_secret == null ) {
            throw new InvalidArgumentException(self::INVALID_CLIENT_SECRET);
        }
        if ( $this->grant_type == 'authorization_code' ) {
            if ( $this->code == null ) {
                throw new InvalidArgumentException(self::INVALID_AUTH_CODE);
            }
            if ( $this->redirect_uri == null ) {
                throw new InvalidArgumentException(self::INVALID_REDIRECT_URI);
            }
        }
        if ( $this->grant_type == 'refresh_token' ) {
            if ( $this->refresh_token == null ) {
                throw new InvalidArgumentException(self::INVALID_REFRESH_TOKEN);
            }
        }
        return true;
    }
}
