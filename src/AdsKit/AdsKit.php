<?php
namespace HMS\AdsKit;

use HMS\AccountKit\AccountKit;
use HMS\Core\Wrapper;
use stdClass;

/**
 * Class HMS AdsKit Wrapper
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/query-publisher-service-reports-0000001050933546">Publisher Service Reporting API</a>
 * @author Martin Zeitler
 */
class AdsKit extends Wrapper {

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

    public function publisher_report( string $start_date, string $end_date, stdClass $filtering, string $group_by, string $time_granularity, int $page=1, int $page_size=10, string|null $order_field=null, string|null $order_type=null ): stdClass {
        return $this->guzzle_post(Constants::ADS_KIT_BASE_URL, $this->auth_headers(), [
            'start_date' => $start_date, // mandatory
            'end_date' => $end_date,     // mandatory
            'filtering' => $filtering,   // mandatory
            'group_by' => $group_by,
            'time_granularity' => $time_granularity,
            'page' => $page,
            'page_size' => $page_size,
            'order_field' => $order_field,
            'order_type' => $order_type
        ]);
    }
}
