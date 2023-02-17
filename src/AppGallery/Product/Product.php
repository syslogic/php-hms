<?php /** @noinspection PhpUnused */
namespace HMS\AppGallery\Product;

use HMS\AppGallery\Connect;
use HMS\AppGallery\Constants;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Class HMS AppGallery Connect Product Wrapper
 *
 * @author Martin Zeitler
 */
class Product extends Connect {

    /** Constructor */
    public function __construct( array|string $config ) {
        parent::__construct( $config );
        $this->base_url = Constants::CONNECT_API_BASE_URL;
        if (isset($config['base_url'])) {$this->base_url = $config['base_url'];}
        $this->access_token = $this->get_access_token(true);
    }

    /**
     * Provide HTTP request headers as array.
     * @param bool $team_admin It determines which client_id to send.
     */
    #[ArrayShape(['Content-Type' => 'string', 'Authorization' => 'string', 'client_id' => 'string', 'appId' => 'string'])]
    protected function auth_headers( bool $team_admin=false ): array {
        return [
            'Content-Type' => 'application/json;charset=utf-8',
            'Authorization' => "Bearer $this->access_token",
            'client_id' => $team_admin ? $this->agc_team_client_id : $this->agc_project_client_id,
            'appId' => $this->oauth2_client_id
        ];
    }

    /** @link https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-addproduct-0000001115868346 Creating a Product */
    public function create_product( array $item=[] ): \stdClass {
        $url = $this->base_url.Constants::PMS_API_PRODUCT_URL;
        $headers = $this->auth_headers(true);
        $payload = ['requestId' => uniqid('hms_'), 'product' => $item];
        return $this->request('POST', $url, $headers, $payload );
    }

    /** @link https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-updateproduct-0000001162548125 Updating a Product */
    public function update_product( array $item=[] ): \stdClass {
        $url = $this->base_url.Constants::PMS_API_PRODUCT_URL;
        $headers = $this->auth_headers(true);
        $payload = ['requestId' => uniqid('hms_'), 'resource' => $item];
        return $this->request('PUT', $url, $headers, $payload );
    }

    /** @link https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-getproductinfo-0000001162468147 Querying Details of a Product */
    public function product_info( string $product_code ): \stdClass {
        $url = $this->base_url.Constants::PMS_API_PRODUCT_URL;
        $headers = $this->auth_headers(true);
        $payload = ['productNo' => $product_code];
        return $this->request('GET', $url, $headers, $payload );
    }

    /** @link https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-addproductgroup-0000001116028254 Creating a Product Subscription Group */
    public function create_product_subscription_group( string $group_name ): \stdClass {
        $url = $this->base_url.Constants::PMS_API_PRODUCT_SUBSCRIPTION_GROUP_URL;
        $headers = $this->auth_headers(true);
        $data = ['groupName' => $group_name, 'status' => 'active'];
        $payload = ['requestId' => uniqid('hms_'), 'resource' => $data];
        return $this->request('POST', $url, $headers, $payload );
    }

    /** @link https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-updateproductgroup-0000001162548123 Updating a Product Subscription Group */
    public function update_product_subscription_group( string $group_id, string $group_name, bool $status=true): \stdClass {
        $url = $this->base_url.Constants::PMS_API_PRODUCT_URL;
        $headers = $this->auth_headers(true);
        $data = ['$groupId' => $group_id, 'groupName' => $group_name, 'status' => $status ? 'active' : 'delete'];
        $payload = ['requestId' => uniqid('hms_'), 'resource' => $data];
        return $this->request('PUT', $url, $headers, $payload );
    }

    /**
     * @link https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-getproductgroup-0000001115868348 Querying Product Subscription Groups
     * @param int $page_num   Query start page number. The default value is 1.
     * @param int $page_size  Number of records on each page. The default value is 20. Value range: 1-300
     * @param string|null $order_by Indicates whether the query results are sorted in ascending or descending order.
     * A JSON object needs to be passed, in which key indicates the attribute name and value specifies the ordering mode.
     * If this parameter is not passed, the query results are sorted by creation time in the database in descending order by default.
     * The options of key are as follows:
     * - name: subscription group name.
     * - createTime: creation time.
     * - updateTime: update time.
     * The options of value are desc (descending order) and asc (ascending order).
     * For example, to sort records by name in descending order and createTime in ascending order,
     * use the configuration {"name": "desc","createTime": "asc"}.
     * @param string|null $request_id Request sequence number, which is a unique identifier defined by you.
     */
    public function product_subscription_groups( int $page_num=1, int $page_size=20, ?string $order_by=null, ?string $request_id=null ): \stdClass {
        $url = $this->base_url.Constants::PMS_API_PRODUCT_SUBSCRIPTION_GROUPS_URL;
        $headers = $this->auth_headers(true);
        $payload = [
            'requestId' => $request_id ?? uniqid('hms_'),
            // 'orderBy' => (object) ['name' => 'asc'],
            'pageSize' => $page_size,
            'pageNum' => $page_num
        ];
        return $this->request('POST', $url, $headers, $payload );
    }

    /** @link https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-addpromotion-0000001115868352 Creating a Product Promotion */
    public function create_product_promotion( string $group_name ): \stdClass {
        $url = $this->base_url.Constants::PMS_API_PRODUCT_PROMOTION_URL;
        $headers = $this->auth_headers(true);
        $data = ['groupName' => $group_name, 'status' => 'active'];
        $payload = ['requestId' => uniqid('hms_'), 'resource' => $data];
        return $this->request('POST', $url, $headers, $payload );
    }

    /** @link https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-updatepromotion-0000001162468151 Updating a Product Promotion */
    public function update_product_promotions( array $item=[] ): \stdClass {
        $url = $this->base_url.Constants::PMS_API_PRODUCT_PROMOTION_URL;
        $headers = $this->auth_headers(true);
        $payload = ['requestId' => uniqid('hms_'), 'resource' => $item];
        return $this->request('PUT', $url, $headers, $payload );
    }

    /** @link https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-getpromotioninfo-0000001116028260 Querying Promotion Details of a Product */
    public function product_promotion_info( string $promotion_id=null ): \stdClass {
        $url = $this->base_url.Constants::PMS_API_PRODUCT_PROMOTION_URL."?promotionId=$promotion_id";
        $headers = $this->auth_headers(true);
        return $this->request('GET', $url, $headers );
    }

    /** @link https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-bygetpromotioninfo-0000001162548129 Searching Product Promotions by Criteria */
    public function product_promotions( array $query=[] ): \stdClass {
        $url = $this->base_url.Constants::PMS_API_PRODUCT_PROMOTIONS_QUERY_URL;
        $headers = $this->auth_headers(true);
        $payload = array_merge(['requestId' => uniqid('hms_')], $query);
        return $this->request('POST', $url, $headers, $payload );
    }
}
