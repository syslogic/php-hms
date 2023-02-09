<?php
namespace HMS\SearchKit;

use HMS\Core\Wrapper;
use InvalidArgumentException;
use stdClass;

/**
 * Class HMS SearchKit Wrapper
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/overview-0000001057087079">SearchKit</a>
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-Guides/open-platform-oauth-0000001053629189#section1022911426469">Authorization Code</a>
 * @author Martin Zeitler
 */
class SearchKit extends Wrapper {

    /**
     * @var string|null $client_ip IP address of a user device.
     * You are advised to pass it for localization when connecting to the Search Kit server.
     */
    private ?string $client_ip = null;

    /** @var string|null $request_id .Unique ID of a request. */
    private ?string $request_id = null;

    private string $base_url;

    public function __construct( array|string $config ) {

        parent::__construct( $config );
        if (is_array($config) && isset($config['access_token'])) {
            $this->access_token = $config['access_token'];
        } else {
            throw new InvalidArgumentException('SearchKit requires an user access token.');
        }

        // $this->base_url = Constants::SEARCH_KIT_BASE_URL;
        $this->base_url = Constants::SEARCH_KIT_BASE_URL_EU;
        $this->post_init();
    }

    /** Unset properties irrelevant to the child class. */
    protected function post_init(): void {
        unset($this->api_key, $this->api_signature);
    }

    /** Provide HTTP request headers as array. */
    protected function auth_header(): array {
        return [
            "Accept: application/json; charset=utf-8",
            "Content-Type: application/json; charset=utf-8",
            "Authorization: Bearer $this->access_token",
            "X-Kit-AppID: $this->oauth2_client_id",
            "X-Kit-ClientIP: $this->client_ip",
            "X-Kit-RequestID: $this->request_id"
        ];
    }

    public function web_search( string $value ): stdClass {
        $url = $this->base_url . Constants::SEARCH_KIT_WEB_SEARCH_URL.'?'.http_build_query(['q' => $value]);
        return $this->guzzle_get($url, $this->auth_header(), []);
    }
    public function image_search( string $value ): stdClass {
        $url = $this->base_url . Constants::SEARCH_KIT_IMAGE_SEARCH_URL.'?'.http_build_query(['q' => $value]);
        return $this->guzzle_get($url, $this->auth_header(), []);
    }
    public function video_search( string $value ): stdClass {
        $url = $this->base_url . Constants::SEARCH_KIT_VIDEO_SEARCH_URL.'?'.http_build_query(['q' => $value]);
        return $this->guzzle_get($url, $this->auth_header(), []);
    }
    public function news_search( string $value ): stdClass {
        $url = $this->base_url . Constants::SEARCH_KIT_NEWS_SEARCH_URL.'?'.http_build_query(['q' => $value]);
        return $this->guzzle_get($url, $this->auth_header(), []);
    }
}
