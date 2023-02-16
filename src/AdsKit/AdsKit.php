<?php
namespace HMS\AdsKit;

use HMS\AccountKit\AccountKit;
use HMS\Core\Wrapper;
use InvalidArgumentException;
use stdClass;

/**
 * Class HMS AdsKit Wrapper
 *
 * @link https://developer.huawei.com/consumer/en/service/ads/publisher/html/#/mainContent/reportData Petal Publisher Center
 * @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/query-publisher-service-reports-0000001050933546 Publisher Service Reporting API
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

    public function publisher_report( string $start_date, string $end_date, stdClass $filtering, string|null $group_by=null, string|null $time_granularity=null, int|null $page=1, int|null $page_size=10, string|null $order_field=null, string|null $order_type=null ): stdClass {
        $post_fields = [
            'start_date' => $start_date, // mandatory
            'end_date' => $end_date,     // mandatory
            'filtering' => $filtering,   // mandatory
            'group_by' => $group_by,
            'time_granularity' => $time_granularity,
            'page' => $page,
            'page_size' => $page_size,
            'order_field' => $order_field,
            'order_type' => $order_type
        ];

        if (! property_exists($filtering, 'currency')) {
            throw new InvalidArgumentException('filtering by currency is mandatory');
        }

        if (property_exists($filtering, 'ad_types')) {
            if (! is_array($filtering->ad_types)) {
                throw new InvalidArgumentException('filtering by ad format requires an array');
            }
            foreach ($filtering->ad_types as $ad_format) {
                if (!in_array($ad_format, Constants::ADS_KIT_FORMATS)) {
                    throw new InvalidArgumentException('invalid ad format value: ' . $ad_format);
                }
            }
        }

        if ($group_by == null) {
            unset($post_fields['group_by']);
        } else if (!in_array($group_by, Constants::ADS_KIT_GROUPING)) {
            throw new InvalidArgumentException('invalid grouping value: ' . $group_by);
        }

        if ($time_granularity == null) {
            unset($post_fields['time_granularity']);
        } else if (!in_array($time_granularity, Constants::ADS_KIT_GRANULARITY)) {
            throw new InvalidArgumentException('invalid granularity value: ' . $time_granularity);
        }

        if ($order_field == null) {
            unset($post_fields['order_field']);
            unset($post_fields['order_type']);
        } else if (!in_array($order_field, Constants::ADS_KIT_ORDER_FIELDS)) {
            throw new InvalidArgumentException('invalid order-field value: ' . $order_field);
        }

        if ($order_type == null) {
            unset($post_fields['order_field']);
            unset($post_fields['order_type']);
        } else if (!in_array($order_type, Constants::ADS_KIT_ORDER_TYPES)) {
            throw new InvalidArgumentException('invalid order-type value: ' . $order_type);
        }
        return $this->request('POST', Constants::ADS_KIT_BASE_URL, $this->auth_headers(), $post_fields);
    }
}
