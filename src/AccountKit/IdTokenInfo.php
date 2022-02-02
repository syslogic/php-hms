<?php
namespace HMS\AccountKit;

use HMS\Core\Model;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

/**
 * Class HMS AccountKit ID Token Info
 *
 * "typ": "JWT",
 * "alg": "RS256",
 * "kid": "6a2880c5d6a88cc4643e88eb680e05197d5bebd855a47b71757fc1b9530809ca",
 * "at_hash": "Dx5WUwUzPelAL-SKuAvWUg",
 * "sub": "MDELaZGxQ9WhqHVqkEVYqVXnQyLXjp8rVhfmlRpx8J9XrQ",
 * "iss": "https://accounts.huawei.com",
 * "locale": "zh-cn",
 * "display_name": "Jack",
 * "given_name": "Zhang San",
 * "name": "Zhang San",
 * "nonce": "salfdjojuiewrrlkjdsffsd",
 * "aud": "300035233",
 * "azp": "300035233",
 * "exp": 1563823909,
 * "iat": 1563820309,
 * "email": "15200006666"
 *
 * @author Martin Zeitler
 */
class IdTokenInfo extends Model {

    protected array $mandatory_fields = ['typ', 'alg', 'kid'];
    protected array $optional_fields = ['at_hash', 'sub', 'iss', 'locale', 'display_name', 'given_name', 'name', 'nonce', 'aud', 'azp', 'exp', 'iat', 'email'];

    /**
     * @var string|null $typ
     */
    private string|null $typ = null;

    /**
     *
     * @var string|null $alg
     */
    private string|null $alg = null;

    /**
     *
     * @var string|null $kid
     */
    private string|null $kid = null;

    /**
     *
     * @var string|null $at_hash
     */
    private string|null $at_hash = null;

    /**
     *
     * @var string|null $sub
     */
    private string|null $sub = null;

    /**
     *
     * @var string|null $iss
     */
    private string|null $iss = null;

    /**
     *
     * @var string|null $locale
     */
    private string|null $locale = null;

    /**
     *
     * @var string|null $display_name
     */
    private string|null $display_name = null;
    #
    /**
     *
     * @var string|null $given_name
     */
    private string|null $given_name = null;

    /**
     *
     * @var string|null $name
     */
    private string|null $name = null;

    /**
     *
     * @var string|null $nonce
     */
    private string|null $nonce = null;

    /**
     *
     * @var int $aud
     */
    private int $aud = 0;

    /**
     *
     * @var int $azp
     */
    private int $azp = 0;

    /**
     *
     * @var int $exp
     */
    private int $exp  = 0;

    /**
     *
     * @var int $iat
     */
    private int $iat = 0;

    /**
     *
     * @var int $email
     */
    private int $email = 0;

    public function __construct(object|array $data) {
        if (is_object($data)) {
            $this->parse_array((array)$data);
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
            'kid' => $this->kid
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
