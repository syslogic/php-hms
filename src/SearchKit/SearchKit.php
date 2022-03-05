<?php
namespace HMS\SearchKit;

use HMS\AccountKit\AccountKit;
use HMS\Core\Wrapper;

/**
 * Class HMS SearchKit Wrapper
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/overview-0000001057087079">SearchKit</a>
 * @author Martin Zeitler
 */
class SearchKit extends Wrapper {

    /**
     * @var string|null $client_ip IP address of a user device.
     * You are advised to pass it for localization when connecting to the Search Kit server.
     */
    private string|null $client_ip = null;

    /** @var string|null $request_id .Unique ID of a request. */
    private string|null $request_id = null;

    public function __construct( array|string $config ) {
        parent::__construct( $config );

        /* Obtain an access-token. */
        $account_kit = new AccountKit( $config );
        $this->access_token = $account_kit->get_access_token();
    }

    /** Unset properties irrelevant to the child class. */
    protected function post_init() {
        unset($this->api_key, $this->api_signature);
    }

    /** Provide HTTP request headers as array. */
    protected function auth_header(): array {
        return [
            "Content-Type: application/json; charset=utf-8",
            "Authorization: Bearer $this->access_token",
            "X-Kit-AppID: $this->app_id",
            "X-Kit-ClientIP: $this->client_ip",
            "X-Kit-RequestID: $this->request_id"
        ];
    }
}
