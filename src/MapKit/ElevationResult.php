<?php
namespace HMS\MapKit;

use HMS\Core\Model;
use JetBrains\PhpStorm\Pure;

/**
 * Class HMS MapKit ElevationResult
 *
 * @author Martin Zeitler
 */
class ElevationResult extends Model {

    protected array $mandatory_fields = ['elevation', 'location', 'resolution'];

    /**
     * Coordinates of the northeast corner.
     *
     * @var int $elevation
     */
    private int $elevation;

    /**
     * Longitude and latitude.
     *
     * @var Coordinate $location
     */
    private Coordinate $location;

    /**
     * Maximum distance between elevation data points, in meters.
     *
     * @var int $resolution
     */
    private int $resolution;

    public function __construct( array $data ) {
        $this->parse_array( $data );
    }

    private function parse_array( array $data ): void {
        foreach ($data as $key => $value) {
            if ( in_array($key, $this->mandatory_fields) ) {
                if ( is_array($value) ) {
                    $this->$key = new Coordinate( $value );
                } else {
                    $this->$key = $value;
                }
            }
        }
    }

    public function getElevation(): int {
        return $this->elevation;
    }

    public function getLocation(): Coordinate {
        return $this->location;
    }

    public function getResolution(): int {
        return $this->resolution;
    }

    #[Pure]
    public function asObject(): object {
        return (object) [
            'elevation'  => $this->elevation,
            'location'   => $this->location->asObject(),
            'resolution' => $this->resolution
        ];
    }

    static function fromArray( array $model ): ElevationResult {
        return new ElevationResult( $model );
    }

    function validate(): bool {
        return true;
    }
}
