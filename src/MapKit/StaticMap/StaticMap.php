<?php /** @noinspection PhpUnused */
namespace HMS\MapKit\StaticMap;

use HMS\MapKit\Constants;

/**
 * Class HMS MapKit Static API
 *
 * @author Martin Zeitler
 */
class StaticMap {

    private string $url_static;

    public function __construct(string $api_key ) {
        $this->setStaticUrl(Constants::MAPKIT_BASE_URL . Constants::MAPKIT_STATIC_MAP_URL . $api_key );
    }

    private function setStaticUrl(string $value): void {
        $this->url_static = $value;
    }

    public function getStaticUrl(): string {
        return $this->url_static;
    }
}
