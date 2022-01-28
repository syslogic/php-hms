<?php
namespace HMS\AgConnect\AuthService;

use HMS\Core\Wrapper;

/**
 * Class HMS AppGallery Connect AuthService Wrapper
 *
 * @author Martin Zeitler
 */
class AuthService extends Wrapper {

    public function __construct( array|string $config ) {
        parent::__construct( $config );
    }

    /**
     * POST: Importing Users.
     *
     * @see <a href="https://developer.huawei.com/consumer/de/doc/development/AppGallery-connect-References/server-rest-import-0000001136020892">Importing Users</a>
     */
    public function import_users() {

    }

    /**
     * POST: Exporting Users.
     *
     * @see <a href="https://developer.huawei.com/consumer/de/doc/development/AppGallery-connect-References/server-rest-import-0000001136020892">Exporting Users</a>
     */
    public function export_users() {

    }

    /**
     * GET: Authenticating a User's Access Token.
     *
     * @see <a href="https://developer.huawei.com/consumer/de/doc/development/AppGallery-connect-References/server-rest-verify-0000001182300271">Authenticating a User's Access Token</a>
     */
    public function authenticate_access_token() {

    }

    /**
     * POST Revoking a User's Access Token.
     *
     * @see <a href="https://developer.huawei.com/consumer/de/doc/development/AppGallery-connect-References/server-rest-revoke-0000001182420193">Authenticating a User's Access Token</a>
     */
    public function revoke_access_token() {

    }
}
