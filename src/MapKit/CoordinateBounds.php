<?php
namespace HMS\MapKit;

use HMS\Core\Model;
use JetBrains\PhpStorm\Pure;

/**
 * Class HMS MapKit CoordinateBounds
 *
 * @author Martin Zeitler
 */
class CoordinateBounds extends Model {

    protected array $mandatory_fields = ['northeast', 'southwest'];

    /**
     * Coordinates of the northeast corner.
     *
     * @var Coordinate $northeast
     */
    private Coordinate $northeast;

    /**
     * Coordinates of the southwest corner.
     *
     * @var Coordinate $southwest
     */
    private Coordinate $southwest;

    public function __construct( array $data ) {
        $this->parse_array( $data );
    }

    private function parse_array( array $data ): void {
        foreach ($data as $key => $value) {
            if ( in_array($key, $this->mandatory_fields) ) {
                if ( is_array($value) ) {
                    $this->$key = new Coordinate( $value );
                }
            }
        }
    }

    public function getNorthEast(): Coordinate {
        return $this->northeast;
    }

    public function getSouthWest(): Coordinate {
        return $this->southwest;
    }

    #[Pure]
    public function asObject(): object {
        return (object) [
            'northeast' => $this->northeast->asObject(),
            'southwest' => $this->southwest->asObject()
        ];
    }

    static function fromArray( array $model ): CoordinateBounds {
        return new CoordinateBounds( $model );
    }

    function validate(): bool {
        return true;
    }
}
