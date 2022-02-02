<?php
namespace HMS\AccountKit;

use HMS\Core\Model;
use InvalidArgumentException;

/**
 * Class HMS AccountKit UserInfo
 *
 * @author Martin Zeitler
 */
class UserInfo extends Model {

    protected array $mandatory_fields = ['openID', 'displayName'];
    protected array $optional_fields  = ['headPictureURL', 'email'];

    /**
     * OpenID.
     *
     * @var string|null $openID
     */
    private string|null $openID = null;

    /**
     * When getNickName is set to 0 or not set, the anonymous account is returned.
     * If the anonymous account is unavailable, the nickname is returned.
     *
     * When getNickName is set to 1, the nickname is returned.
     * If the nickname is unavailable, the anonymous account is returned.
     *
     * @var string|null $displayName
     */
    private string|null $displayName = null;

    /**
     * Profile picture.
     *
     * @var string|null $headPictureURL
     */
    private string|null $headPictureURL = null;

    /**
     * Email address of a user.
     *
     * @var string|null $email
     */
    private string|null $email = null;

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
    public function asArray(): array {
        $data = [];
        if ($this->openID         != null) {$data['openID']         = $this->openID;}
        if ($this->displayName    != null) {$data['displayName']    = $this->displayName;}
        if ($this->headPictureURL != null) {$data['headPictureURL'] = $this->headPictureURL;}
        if ($this->email          != null) {$data['email']          = $this->email;}
        return $data;
    }

    public function asObject(): object {
        return (object) $this->asArray();
    }

    static function fromArray( array $model ): UserInfo {
        return new UserInfo( $model );
    }

    function validate(): bool {
        if ( $this->openID == null ) {
            throw new InvalidArgumentException( 'openID must not be null' );
        }
        if ( $this->displayName == null ) {
            throw new InvalidArgumentException( 'displayName must not be null' );
        }
        return true;
    }
}
