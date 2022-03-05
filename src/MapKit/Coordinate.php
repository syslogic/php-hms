<?php
namespace HMS\MapKit;

use HMS\Core\Model;
use InvalidArgumentException;

/**
 * Class HMS MapKit Coordinate
 *
 * @author Martin Zeitler
 */
class Coordinate extends Model {

    private const LATITUDE_OUT_OF_BOUNDS = 'latitude is out of bounds: ';
    private const LONGITUDE_OUT_OF_BOUNDS = 'longitude is out of bounds: ';

    protected array $mandatory_fields = ['lat', 'lng'];

    /**
     * Latitude.
     * The value range is [-90, 90].
     * @var float $lat
     */
    private float $lat = 0.0;

    /**
     * Longitude.
     * The value range is [-180, 180].
     * @var float $lng
     */
    private float $lng = 0.0;

    public function __construct( array $data ) {
        $this->parse_array( $data );
    }

    private function parse_array( array $data ): void {
        foreach ($data as $key => $value) {
            if ( in_array($key, $this->mandatory_fields) ) {
                $this->$key = (float) $value;
            }
        }
    }

    public function asObject(): object {
        return (object) [
            'lat' => $this->lat,
            'lng' => $this->lng
        ];
    }

    static function fromArray( array $model ): Coordinate {
        return new Coordinate( $model );
    }

    function validate(): bool {
        if (abs($this->lat) > 90.0) {
            throw new InvalidArgumentException(self::LATITUDE_OUT_OF_BOUNDS . $this->lat);
        }
        if (abs($this->lng) > 180.0) {
            throw new InvalidArgumentException(self::LONGITUDE_OUT_OF_BOUNDS . $this->lng);
        }
        return true;
    }

    public function asString(): string {
        return $this->lat.','.$this->lng;
    }
}
