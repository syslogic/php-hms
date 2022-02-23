<?php /** @noinspection PhpUnused */
namespace HMS\MapKit\StaticMap;

use HMS\MapKit\Constants;

/**
 * Class HMS MapKit Static API
 *
 * @author Martin Zeitler
 */
class StaticMap {

    private string $base_url;

    public function __construct(string $api_key ) {
        $this->base_url = Constants::MAPKIT_BASE_URL . Constants::MAPKIT_STATIC_MAP_URL . $api_key;
    }
}
