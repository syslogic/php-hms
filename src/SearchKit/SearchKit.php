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
    private ?string $client_ip = '127.0.0.1';

    /** @var string|null $request_id .Unique ID of a request. */
    private ?string $request_id = '';

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
        unset($this->oauth2_client_secret, $this->oauth2_api_scope, $this->oauth2_api_scope, $this->oauth2_redirect_url);
        unset($this->token_expiry, $this->refresh_token, $this->id_token, $this->package_name, $this->product_id);
        unset($this->agc_client_id, $this->agc_client_secret);
        unset($this->developer_id, $this->project_id);
        unset($this->api_key, $this->api_signature);

        $urls = [Constants::SEARCH_KIT_BASE_URL, Constants::SEARCH_KIT_BASE_URL_EU];
        if (! in_array($this->base_url, $urls)) {
            throw new InvalidArgumentException('SearchKit permits these base_url values: '. implode(', ', $urls));
        }
    }

    /** Provide HTTP request headers as array. */
    protected function auth_header(): array {
        return [
            "Accept" => "application/json; charset=utf-8",
            "Content-Type" => "application/json; charset=utf-8",
            "Authorization" => "Bearer $this->access_token",
            "X-Kit-AppID" => $this->oauth2_client_id,
            // "X-Kit-ClientIP" => $this->client_ip,
            // "X-Kit-RequestID" => $this->request_id
        ];
    }

    /** @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/web-search-0000001056849539">Searching for a Web Page</a> */
    public function web_search( string $value ): stdClass {
        $query = ['q' => $value, 'lang' => 'en'];
        $url = $this->base_url . Constants::SEARCH_KIT_WEB_SEARCH_URL.'?'.http_build_query($query);
        return $this->request( 'GET', $url, $this->auth_header());
    }

    /** @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/image-search-0000001057330814">Searching for an Image</a> */
    public function image_search( string $value ): stdClass {
        $query = ['q' => $value, 'lang' => 'en'];
        $url = $this->base_url . Constants::SEARCH_KIT_IMAGE_SEARCH_URL.'?'.http_build_query($query);
        return $this->request( 'GET', $url, $this->auth_header());
    }

    /** @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/video-search-0000001057330836">Searching for a Video</a> */
    public function video_search( string $value ): stdClass {
        $query = ['q' => $value, 'lang' => 'en'];
        $url = $this->base_url . Constants::SEARCH_KIT_VIDEO_SEARCH_URL.'?'.http_build_query($query);
        return $this->request( 'GET', $url, $this->auth_header());
    }

    /** @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/news-search-0000001055690931">Searching for News</a> */
    public function news_search( string $value ): stdClass {
        $query = ['q' => $value, 'lang' => 'en'];
        $url = $this->base_url . Constants::SEARCH_KIT_NEWS_SEARCH_URL.'?'.http_build_query($query);
        return $this->request( 'GET', $url, $this->auth_header());
    }
}
