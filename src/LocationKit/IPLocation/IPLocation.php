<?php /** @noinspection PhpUnused */
namespace HMS\LocationKit\IPLocation;

use HMS\LocationKit\Constants;
use HMS\LocationKit\LocationKit;
use stdClass;

/**
 * Class HMS LocationKit IP Location API
 * Note: Not being implemented.
 *
 * @author Martin Zeitler
 */
class IPLocation extends LocationKit {

    public function __construct( array $config ) {
        parent::__construct( $config );
        if ( isset($config['ip_address']) ) {
            $this->get_ip_location( $config['ip_address'] );
        }
        return $this;
    }

    private function get_ip_location( string $value ): void {
        $payload = ['ip' => $value ];
        $headers = $this->auth_headers();
        $headers['x-forwarded-for'] = $value;
        $this->result = $this->guzzle_post(Constants::IP_LOCATION_BASE_URL, $headers, $payload);
    }

    public function get_result(): stdClass {
        return $this->result;
    }
}
