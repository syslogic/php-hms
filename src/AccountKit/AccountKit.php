<?php
namespace HMS\AccountKit;

use HMS\Core\Wrapper;

/**
 * Class HMS AccountKit Wrapper
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/account-obtain-token_hms_reference-0000001050048618">AccountKit</a>
 * @author Martin Zeitler
 */
class AccountKit extends Wrapper {

    /** oAuth2 Token related. */
    private string|null $url_token_refresh = Constants::URL_OAUTH2_TOKEN_REFRESH_V3;
    protected string|null $access_token = null;
    protected string|null $refresh_token = null;
    private int $token_expiry = 0;

    /** ID Token related. */
    private string|null $id_token = null;
    private string|null $token_scope = null;
    private string|null $union_id = null;
    private string|null $open_id = null;

    public function __construct( array|string $config ) {
        parent::__construct( $config );
    }
}
