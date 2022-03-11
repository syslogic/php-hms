<?php /** @noinspection PhpUnused */
namespace HMS\LocationKit\IPLocation;

use HMS\LocationKit\LocationKit;
use HMS\LocationKit\Constants;

/**
 * Class HMS LocationKit IPLocation API
 *
 * @author Martin Zeitler
 */
class IPLocation extends LocationKit {

    private string $url_ip_location;

    public function __construct( array $config ) {
        parent::__construct( $config );
        $this->setIPLocationUrl(Constants::IP_LOCATION_BASE_URL );
    }

    private function setIPLocationUrl( string $value ): void {
        $this->url_ip_location = $value;
    }

    private function getIpLocationUrl(): string {
        return $this->url_ip_location;
    }
}
