<?php
namespace HMS\AppGallery\AuthService;

use HMS\Core\Model;

/**
 * Class HMS AppGallery Connect AuthService ImportUser
 *
 * @author Martin Zeitler
 */
class ImportUser extends Model {

    protected array $mandatory_fields = ['importUid'];
    protected array $optional_fields  = [
        'displayName', 'photoUrl', 'email', 'emailVerified', 'phone',
        'createTime', 'lastLoginTime', 'passwordHash', 'passwordSalt',
        'providers'
    ];

    /** @var string|null $importUid (1024) Unique ID of a user (mandatory). */
    private string|null $importUid = null;

    /** @var string|null $displayName (1024) User nickname. */
    private string|null $displayName = null;

    /** @var string|null $photoUrl (2048) Profile picture URL. */
    private string|null $photoUrl = null;

    /**
     * @var string|null $email (512) Email address of a user.
     * This parameter cannot be empty when the value of providerId in providers is 12.
     */
    private string|null $email = null;

    /**
     * Indicates whether the email address needs to be verified. The value can be true or false.
     * This parameter cannot be empty when the value of providerId in providers is 12.
     * @var bool|null $emailVerified.
     */
    private bool|null $emailVerified = null;

    /**
     * @var string|null $phone (32) Mobile number, which must be
     * in the format of +Country/Region code-Mobile number. Example: +86-18260096275
     * This parameter cannot be empty when the value of providerId in providers is 11.
     */
    private string|null $phone = null;

    /** @var string|null $createTime (20) Total number of milliseconds between the time when a user is created and 1970-01-01 00:00:00.  */
    private string|null $createTime = null;

    /** @var string|null $lastLoginTime (20) Total number of milliseconds between the time of the last user sign-in and 1970-01-01 00:00:00.  */
    private string|null $lastLoginTime = null;

    /**
     * @var string|null $passwordHash (8192) Password encrypted using PBKDF2WithSHA256,
     * with 10,000 iterations and the salt value specified by `passwordSalt`.
     */
    private string|null $passwordHash = null;

    /** @var string|null $passwordSalt (8192) Salt value for password encryption.  */
    private string|null $passwordSalt = null;

    /** @var array|null $providers Third-party authentication information. */
    private array|null $providers = null;

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
        if ($this->importUid     != null) {$data['importUid']     = $this->importUid;}
        if ($this->displayName   != null) {$data['displayName']   = $this->displayName;}
        if ($this->photoUrl      != null) {$data['photoUrl']      = $this->photoUrl;}
        if ($this->email         != null) {$data['email']         = $this->email;}
        if ($this->phone         != null) {$data['phone']         = $this->phone;}
        if ($this->createTime    != null) {$data['createTime']    = $this->createTime;}
        if ($this->lastLoginTime != null) {$data['lastLoginTime'] = $this->lastLoginTime;}
        if ($this->passwordHash  != null) {$data['passwordHash']  = $this->passwordHash;}
        if ($this->passwordSalt  != null) {$data['passwordSalt']  = $this->passwordSalt;}
        if ($this->providers     != null) {$data['providers']     = $this->providers;}
        return $data;
    }

    public function asObject(): object {
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
