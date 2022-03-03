<?php /** @noinspection PhpUnused */
namespace HMS\MapKit\StaticMap;

use HMS\MapKit\Constants;
use HMS\MapKit\MapKit;

/**
 * Class HMS MapKit Static API
 *
 * @author Martin Zeitler
 */
class StaticMap extends MapKit {

    private string $url_static;

    public function __construct( array $config ) {
        parent::__construct( $config );
        $this->setStaticUrl(Constants::MAPKIT_BASE_URL . Constants::MAPKIT_STATIC_MAP_URL . $config['api_key'] );
    }

    private function setStaticUrl(string $value): void {
        $this->url_static = $value;
    }

    private function getStaticUrl(): string {
        return $this->url_static;
    }
}
