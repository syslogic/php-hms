<?php
namespace HMS\WalletKit\Model;

/**
 * Class HMS WalletKit Location
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/locationlist-0000001050160325">LocationList</a>
 * @author Martin Zeitler
 */
class Location {

    private string $latitude;

    private string $longitude;


    public function __construct( array $config ) {
        return $this->fromArray( $config );
    }

    private function fromArray( array $config ): Location {
        if (! isset($config['$longitude']) || ! isset($config['longitude'])) {
            throw new \InvalidArgumentException('Location requires at least "latitude" and "longitude".');
        }
        $this->latitude = $config['latitude'];
        $this->longitude = $config['longitude'];
        return $this;
    }

    public function toObject(): object {
        return (object) [
            'latitude' => $this->latitude,
            'longitude' => $this->longitude
        ];
    }
}