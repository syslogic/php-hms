<?php /** @noinspection PhpUnused */
namespace HMS\MapKit\StaticMap;

use HMS\MapKit\Constants;
use HMS\MapKit\Coordinate;
use HMS\MapKit\MapKit;
use stdClass;

/**
 * Class HMS MapKit Static API
 * Note: You must set at least one of the following groups of parameters: markers/path and location/zoom.
 *       If both groups are set, the location/zoom group takes precedence.
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/maps-static-api-0000001059461203">Maps Static API</a>
 * @author Martin Zeitler
 */
class StaticMap extends MapKit {

    private string $url_static;

    public function __construct( array $config ) {
        parent::__construct( $config );
        $this->setStaticUrl(Constants::MAPKIT_STATIC_MAP_URL );
    }

    private function setStaticUrl(string $value): void {
        $this->url_static = $value;
    }

    private function getStaticUrl(): string {
        return $this->url_static;
    }

    /**
     *
     * @param Coordinate $location Address information.
     *                             The value can be a pair of latitude and longitude or a specific address.
     *                             The latitude and longitude are in the Latitude,Longitude format, for example, 41.43206,-81.38992.
     * @param int $width           Image width.
     *                             If scale is set to 1, the value ranges from 0 (excluded) to 1024.
     *                             If scale is set to 2, the value ranges from 0 (excluded) to 512.
     * @param int $height          Image height.
     *                             If scale is set to 1, the value ranges from 0 (excluded) to 1024.
     *                             If scale is set to 2, the value ranges from 0 (excluded) to 512.
     *                             If markers and path are not set, this parameter is mandatory.
     * @param int $zoom            Zoom level. If markers and path are not set, this parameter is mandatory.
     *                             The value ranges from 1 to 17.
     * @param int $scale           Map scale. The options are 1 and 2. The default value is 1.
     *
     *
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-Guides/supported-language-0000001050162899">Supported Languages</a>
     * @return bool|stdClass The result of the API call.
     */
    public function getStaticMapByLocation( Coordinate $location, int $width=256, int $height=256, int $zoom=10, int $scale=1,
                                            string $pattern='PNG', string $mapType='roadmap', string $language='en' ): bool|stdClass {
        $result = $this->guzzle_get($this->getStaticUrl(), $this->request_headers(), [
            'key' => $this->api_key,
            'signature' => $this->api_signature,
            'location' => $location->asString(),
            'width' => $width,
            'height' => $height,
            'zoom' => $zoom,
            'scale' => $scale,
            'pattern' => $pattern,
            'mapType' => $mapType,
            'language' => $language
        ]);
        if (! property_exists($result, 'code')) {$result->code = 200;}
        return $result;
    }

    /**
     * @param string $markers           Marker description. The value can be marker styles, longitudes and latitudes, or addresses.
     *                                  You can enter multiple groups of location information and separate them using vertical bars (|).
     *                                  The following is an example: markers=Marker style|{Latitude 1,Longitude 1}|{Latitude 2,Longitude 2}|Address
     *                                  If the marker style is not specified, markerStyles is used as the default style.
     * @param string|null $markerStyles Marker style description.
     *                                  The attributes that can be set include the following: size, label, color, icon.
     *                                  Example: size:mid|color:black|label:C|icon:https%253A%252F%252Fwww-file.huawei.com%252F-%252Fmedia%252Fcorporate%252Fimages%252Fhome%252Flogo%252Fhuawei_logo.png
     * @param int $width                Image width.
     *                                  If scale is set to 1, the value ranges from 0 (excluded) to 1024.
     *                                  If scale is set to 2, the value ranges from 0 (excluded) to 512.
     * @param int $height               Image height.
     *                                  If scale is set to 1, the value ranges from 0 (excluded) to 1024.
     *                                  If scale is set to 2, the value ranges from 0 (excluded) to 512.
     *                                  If markers and path are not set, this parameter is mandatory.
     * @param int $zoom                 Zoom level. If markers and path are not set, this parameter is mandatory.
     *                                  The value ranges from 1 to 17.
     * @param int $scale                Map scale. The options are 1 and 2. The default value is 1.
     *
     *
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-Guides/supported-language-0000001050162899">Supported Languages</a>
     * @return bool|stdClass The result of the API call.
     */
    public function getStaticMapByMarkers( string $markers, string|null $markerStyles=null, int $width=256, int $height=256,
                                           int $zoom=10, int $scale=1, string $pattern='PNG', string $mapType='roadmap', string $language='en' ): bool|stdClass {
        $result = $this->guzzle_get($this->getStaticUrl(), $this->request_headers(), [
            'key' => $this->api_key,
            'signature' => $this->api_signature,
            'markers' => $markers,
            'markerStyles' => $markerStyles,
            'width' => $width,
            'height' => $height,
            'zoom' => $zoom,
            'scale' => $scale,
            'pattern' => $pattern,
            'mapType' => $mapType,
            'language' => $language
        ]);
        if (! property_exists($result, 'code')) {$result->code = 200;}
        return $result;
    }

    /**
     * @param string $path            Path description. The value can be path styles, longitudes and latitudes, or addresses.
     *                                You can enter multiple groups of location information and separate them using vertical bars (|).
     *                                The following is an example: path=Path style|{Latitude 1,Longitude 1}|{Latitude 2,Longitude 2}|Address
     *                                If the path style is not specified, pathStyles is used as the default style.
     * @param string|null $pathStyles Path style description.
     *                                The attributes that can be set include the following: color, weight, fillcolor.
     *                                If fillcolor is set, the path style is polygon. Otherwise, the path style is polyline.
     *                                Example: color:0x0000ff80|weight:1|fillcolor:0x0000ff80
     * @param int $width              Image width.
     *                                If scale is set to 1, the value ranges from 0 (excluded) to 1024.
     *                                If scale is set to 2, the value ranges from 0 (excluded) to 512.
     * @param int $height             Image height.
     *                                If scale is set to 1, the value ranges from 0 (excluded) to 1024.
     *                                If scale is set to 2, the value ranges from 0 (excluded) to 512.
     *                                If markers and path are not set, this parameter is mandatory.
     * @param int $zoom               Zoom level. If markers and path are not set, this parameter is mandatory.
     *                                The value ranges from 1 to 17.
     * @param int $scale              Map scale. The options are 1 and 2. The default value is 1.
     *
     *
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-Guides/supported-language-0000001050162899">Supported Languages</a>
     * @return bool|stdClass The result of the API call.
     */
    public function getStaticMapByPath( string $path, string|null $pathStyles=null, int $width=256, int $height=256,
                                        int $zoom=10, int $scale=1, string $pattern='PNG', string $mapType='roadmap', string $language='en' ): bool|stdClass {
        $result = $this->guzzle_get($this->getStaticUrl(), $this->request_headers(), [
            'key' => $this->api_key,
            'signature' => $this->api_signature,
            'path' => $path,
            'pathStyles' => $pathStyles,
            'width' => $width,
            'height' => $height,
            'zoom' => $zoom,
            'scale' => $scale,
            'pattern' => $pattern,
            'mapType' => $mapType,
            'language' => $language
        ]);
        if (! property_exists($result, 'code')) {$result->code = 200;}
        return $result;
    }
}
