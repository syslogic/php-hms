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
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/directions-walking-0000001050161494">Route Planning: Walking</a>
     */
    public const MAPKIT_WALKING_DIRECTIONS_URL = "routeService/walking?key=";

    /**
     * POST: Route Planning: Cycling
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/directions-bicycling-0000001050163449">Route Planning: Cycling</a>
     */
    public const MAPKIT_CYCLING_DIRECTIONS_URL = "routeService/bicycling?key=";

    /**
     * POST: Route Planning: Driving
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/directions-driving-0000001050161496">Route Planning: Driving</a>
     */
    public const MAPKIT_DRIVING_DIRECTIONS_URL = "routeService/driving?key=";

    /**
     * POST: Batch Route Planning: Walking
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/matrix-walking-0000001050161506">Batch Route Planning: Walking</a>
     */
    public const MAPKIT_WALKING_MATRIX_URL = "routeService/walkingMatrix?key=";

    /**
     * POST: Batch Route Planning: Cycling
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/matrix-bicycling-0000001050163459">Batch Route Planning: Cycling</a>
     */
    public const MAPKIT_CYCLING_MATRIX_URL = "routeService/bicyclingMatrix?key=";

    /**
     * POST: Batch Route Planning: Driving
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/matrix-driving-0000001050161508">Batch Route Planning: Driving</a>
     */
    public const MAPKIT_DRIVING_MATRIX_URL = "routeService/drivingMatrix?key=";

    /**
     * POST: Snap to Roads API
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/snap-to-roads-api-0000001211128705">Snap to Roads API</a>
     */
    public const MAPKIT_SNAP_TO_ROADS_URL = "routeService/snapToRoads?key=";

    /**
     * GET: Static API
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/maps-static-api-0000001059461203">Static API</a>
     */
    public const MAPKIT_STATIC_MAP_URL = "mapService/getStaticMap?key=";

    /**
     * GET: Tile API
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/tile-api-0000001059859346">Tile API</a>
     */
    public const MAPKIT_MAP_TILE_URL = "mapService/getTile?key=";

    /**
     * POST: Elevation API
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/elevation-api-0000001158669981">Elevation API</a>
     */
    public const MAPKIT_ELEVATION_URL = "elevation/getElevation?key=";

}
