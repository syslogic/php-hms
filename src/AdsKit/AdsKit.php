<?php
namespace HMS\AdsKit;

use HMS\AccountKit\AccountKit;
use HMS\Core\Wrapper;
use http\Exception\InvalidArgumentException;
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

    public function publisher_report( string $start_date, string $end_date, stdClass $filtering, string|null $group_by, string|null $time_granularity, int $page=1, int $page_size=10, string|null $order_field=null, string|null $order_type=null ): stdClass {
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
        if ($group_by != null && !in_array($group_by, Constants::ADS_KIT_GROUPING)) {
            throw new InvalidArgumentException('invalid grouping value: ' . $group_by);
        }
        if ($time_granularity != null && !in_array($time_granularity, Constants::ADS_KIT_GRANULARITY)) {
            throw new InvalidArgumentException('invalid granularity value: ' . $group_by);
        }
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
