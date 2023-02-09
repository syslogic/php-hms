<?php
namespace HMS\GameService;

use HMS\AccountKit\AccountKit;
use HMS\Core\Wrapper;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Class HMS GameService Wrapper
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/verify-login-signature-0000001050123503">GameService</a>
 * @author Martin Zeitler
 */
class GameService extends Wrapper {

    /** Constructor */
    public function __construct( array|string $config ) {

        parent::__construct( $config );
        $this->post_init();

        /* Obtain an access-token. */
        $account_kit = new AccountKit( $config );
        $this->access_token = $account_kit->get_access_token();
    }

    /** Unset properties irrelevant to the child class. */
    protected function post_init(): void {
        unset($this->api_key, $this->api_signature);
    }

    /** Provide HTTP request headers as array. */
    #[ArrayShape(['Content-Type' => 'string', 'Authorization' => 'string', 'developerId' => 'int', 'appId' => 'int', 'productId' => 'int'])]
    protected function auth_headers(): array {
        return [
            'Content-Type' => 'application/json;charset=utf-8',
            'Authorization' => ' Bearer ' . $this->access_token,
            'developerId' => $this->developer_id,
            'appId' => $this->oauth2_client_id,
            'productId' => $this->product_id
        ];
    }

    /*
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/appgallerykit-notifysendproduct-0000001050121556#section715461210577">Request Parameters</>
     * {
     *  "data": {
     *      "developerId": "234234234",
     *      "orderId": "sdfsfff32324324234234",
     *      "openId": "openId13123",
     *      "appId": "1231333",
     *      "count": "1",
     *      "productNo": "product344",
     *      "ts": "12312313123131123"
     *  },
     *  "sign": "xxxxxxxxxxxxxxxxxxxxxxxx"
     *  "extInfos": {    "
     *        payOrderId": "H202002****85C88C365"
     *   }
     * }
     */
    #[ArrayShape(['data' => 'object', 'sign' => 'string', 'extInfos' => 'object'])]
    public function parse_delivery_notification( string $payload ): \stdClass {
        return json_decode($payload);
    }

    /**
     * uses method PUT.
     */
    public function send_delivery_success_notification( string $order_id, string $product_no, string $open_id, int $status=0 ): \stdClass|bool
    {
        return $this->guzzle_put(Constants::CONNECT_DELIVERY_SUCCESS_URL, $this->auth_headers(), [
            "orderId" => $order_id,
            "productNo" => $product_no,
            "openId" => $open_id,
            "status" => $status,
            "ts" => time()
        ]);
    }
}
