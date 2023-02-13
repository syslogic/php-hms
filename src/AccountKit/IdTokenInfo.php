<?php
namespace HMS\AccountKit;

use HMS\Core\Model;
use JetBrains\PhpStorm\Pure;

/**
 * Class HMS AccountKit ID Token Info
 *
 * @author Martin Zeitler
 */
class IdTokenInfo extends Model {

    protected array $mandatory_fields = [
        'typ', 'alg', 'kid'
    ];
    protected array $optional_fields = [
        'iss', 'sub', 'aud', 'exp', 'iat', 'nonce', 'at_hash', 'azp',
        'email_verified', 'email',
        'picture', 'name', 'locale', 'family_name', 'given_name', 'display_name'
    ];

    /**
     * ID token in JWT format.
     *
     * @var string|null $typ
     */
    private string|null $typ = null;

    /**
     * RS256 algorithm used to sign the ID token.
     *
     * @var string|null $alg
     */
    private string|null $alg = null;

    /**
     * ID of the public-private key pair used for signature verification,
     * corresponding to the kid value in obtaining a public key.
     *
     * @var string|null $kid
     */
    private string|null $kid = null;

    /**
     * If the scope contains the openid permission:
     * The value is always https://accounts.huawei.com.
     *
     * @var string $iss
     */
    private string $iss = 'https://accounts.huawei.com';

    /**
     * If the scope contains the openid permission:
     * UnionID of a user. The value of this parameter is the same for all apps of the same developer.
     *
     * @var string|null $sub
     */
    private string|null $sub = null;

    /**
     * If the scope contains the openid permission:
     * App ID, whose information is contained in the ID token.
     *
     * @var int $aud
     */
    private int $aud = 0;

    /**
     * If the scope contains the openid permission:
     * Time when an ID token expires.
     *
     * @var int $exp
     */
    private int $exp  = 0;

    /**
     * If the scope contains the openid permission:
     * Time when an ID token is generated.
     * @var int $iat
     */
    private int $iat = 0;

    /**
     * If the scope contains the openid permission:
     * Case-sensitive string that is randomly generated.
     * If nonce is passed for generating the authorization code,
     * the value of this parameter is the same as that of nonce.
     *
     * @var string|null $nonce
     */
    private string|null $nonce = null;

    /**
     * If the scope contains the openid permission:
     * Access token hash value.
     *
     * @var string|null $at_hash
     */
    private string|null $at_hash = null;

    /**
     * If the scope contains the openid permission:
     * App ID, based on which the ID token is generated.
     *
     * @var int $azp
     */
    private int $azp = 0;

    /**
     * If the scope contains the email permission:
     * Indicates whether a user's email address has been verified.
     *
     * @var bool|null $email_verified
     */
    private bool|null $email_verified = null;

    /**
     * If the scope contains the email permission:
     * Email address. The email address is not mandatory for a HUAWEI ID.
     * Therefore, the response may not contain this parameter.
     *
     * @var string|null $email
     */
    private string|null $email = null;

    /**
     * If the scope contains the profile permission:
     * User profile picture URI.
     *
     * @var string|null $picture
     */
    private string|null $picture = null;

    /**
     * If the scope contains the profile permission:
     * Full name of a user.
     *
     * @var string|null $name
     */
    private string|null $name = null;

    /**
     * If the scope contains the profile permission:
     * Last name.
     *
     * @var string|null $family_name
     */
    private string|null $family_name = null;

    /**
     * If the scope contains the profile permission:
     * First name.
     *
     * @var string|null $given_name
     */
    private string|null $given_name = null;

    /**
     * If the scope contains the profile permission:
     * Nickname of a HUAWEI ID.
     *
     * @var string|null $display_name
     */
    private string|null $display_name = null;

    /**
     * If the scope contains the profile permission:
     * User language, for example, zh-cn or en-us.
     *
     * @var string|null $locale
     */
    private string|null $locale = null;

    public function __construct(object|array $data) {
        if (is_object($data)) {
            $this->parse_array((array) $data);
        } else if (is_array($data)) {
            $this->parse_array($data);
        }
    }

    private function parse_array(array $data): void {
        foreach ($data as $key => $value) {
            if (in_array($key, array_merge($this->mandatory_fields, $this->optional_fields))) {
                $this->$key = $value;
            }
        }
    }

    /** Conditionally adding array items. */
    public function asArray(): array {
        return [
            'typ' => $this->typ,
            'alg' => $this->alg,
            'kid' => $this->kid,
            'iss' => $this->iss,
            'sub' => $this->sub,
            'aud' => $this->aud,
            'exp' => $this->exp,
            'iat' => $this->iat,
            'nonce' => $this->nonce,
            'at_hash' => $this->at_hash,
            'azp' => $this->azp,
            'email_verified' => $this->email_verified,
            'email' => $this->email,
            'name' => $this->name,
            'given_name' => $this->given_name,
            'family_name' => $this->family_name,
            'display_name' => $this->display_name,
            'picture' => $this->picture,
            'locale' => $this->locale
        ];
    }

    #[Pure]
    function asObject(): object {
        return (object) $this->asArray();
    }

    static function fromArray( array $model ): IdTokenInfo {
        return new IdTokenInfo( $model );
    }

    function validate(): bool {
        return true;
    }
}
