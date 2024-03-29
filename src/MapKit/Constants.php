<?php /** @noinspection PhpUnused */
namespace HMS\MapKit;

/**
 * Class HMS MapKit Constants
 *
 * @author Martin Zeitler
 */
class Constants {

    /** Common Base URL */
    public const MAPKIT_BASE_URL = "https://mapapi.cloud.huawei.com/mapApi/v1/";

    /**
     * POST: Route Planning: Walking
     * @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/directions-walking-0000001050161494 Route Planning: Walking
     */
    public const MAPKIT_WALKING_DIRECTIONS_URL = self::MAPKIT_BASE_URL . "routeService/walking?key=";

    /**
     * POST: Route Planning: Cycling
     * @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/directions-bicycling-0000001050163449 Route Planning: Cycling
     */
    public const MAPKIT_CYCLING_DIRECTIONS_URL = self::MAPKIT_BASE_URL . "routeService/bicycling?key=";

    /**
     * POST: Route Planning: Driving
     * @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/directions-driving-0000001050161496 Route Planning: Driving
     */
    public const MAPKIT_DRIVING_DIRECTIONS_URL = self::MAPKIT_BASE_URL . "routeService/driving?key=";

    /**
     * POST: Batch Route Planning: Walking
     * @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/matrix-walking-0000001050161506 Batch Route Planning: Walking
     */
    public const MAPKIT_WALKING_MATRIX_URL = self::MAPKIT_BASE_URL . "routeService/walkingMatrix?key=";

    /**
     * POST: Batch Route Planning: Cycling
     * @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/matrix-bicycling-0000001050163459 Batch Route Planning: Cycling
     */
    public const MAPKIT_CYCLING_MATRIX_URL = self::MAPKIT_BASE_URL . "routeService/bicyclingMatrix?key=";

    /**
     * POST: Batch Route Planning: Driving
     * @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/matrix-driving-0000001050161508 Batch Route Planning: Driving
     */
    public const MAPKIT_DRIVING_MATRIX_URL = self::MAPKIT_BASE_URL . "routeService/drivingMatrix?key=";

    /**
     * POST: Snap to Roads API
     * @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/snap-to-roads-api-0000001211128705 Snap to Roads API
     */
    public const MAPKIT_SNAP_TO_ROADS_URL = self::MAPKIT_BASE_URL . "routeService/snapToRoads?key=";

    /**
     * POST: Elevation API
     * @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/elevation-api-0000001158669981 Elevation API
     */
    public const MAPKIT_ELEVATION_URL = self::MAPKIT_BASE_URL . "elevation/getElevation?key=";

    /**
     * GET: Static Map API
     * @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/maps-static-api-0000001059461203">Static API</a>
     */
    public const MAPKIT_STATIC_MAP_URL = self::MAPKIT_BASE_URL . "mapService/getStaticMap";

    /**
     * GET: Map Tile API
     * @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/tile-api-0000001059859346 Tile API
     */
    public const MAPKIT_MAP_TILE_URL = self::MAPKIT_BASE_URL . "mapService/getTile";
}
