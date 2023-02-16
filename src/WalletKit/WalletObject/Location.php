<?php
namespace HMS\WalletKit\WalletObject;

use HMS\Core\Model;

/**
 * Class HMS WalletKit Location
 *
 * @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/locationlist-0000001050160325 LocationList
 * @author Martin Zeitler
 */
class Location extends Model {

    /** @var string $latitude */
    private string $latitude;

    /** @var string $longitude */
    private string $longitude;

    public function __construct( array $config ) {
        if (! isset($config['latitude']) || ! isset($config['longitude'])) {
            throw new \InvalidArgumentException('Location requires at least "latitude" and "longitude".');
        }
        $this->latitude = $config['latitude'];
        $this->longitude = $config['longitude'];
        return $this;
    }

    public static function fromArray(array $model ): Location {
        return new Location( $model );
    }

    public function asObject(): object {
        return (object) [
            'latitude' => $this->latitude,
            'longitude' => $this->longitude
        ];
    }

    function validate(): bool {
        return true;
    }
}