<?php
namespace HMS\SearchKit;

use HMS\AccountKit\AccountKit;
use HMS\Core\Wrapper;

/**
 * Class HMS SearchKit Wrapper
 *
 * Note: This API requires an "App-level client ID" & "Enable app-level client API".
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-Guides/app-gallery-connect-0000001057712438">Configuring App Information in AppGallery Connect</a>
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/overview-0000001057087079">SearchKit</a>
 * @author Martin Zeitler
 */
class SearchKit extends Wrapper {

    /**
     * @var array $languages Supported search languages.
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/language-code-0000001057569148">Language Codes</a>
     */
    private array $languages = [
        'ar', 'cs', 'da', 'en',' fi',
        'fr', 'de', 'it', 'nb', 'pl',
        'pt', 'es', 'sv', 'tr'
    ];

    /**
     * @var array $regions Supported search regions.
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/search-region-code-0000001057330966">Region Codes</a>
     */
    private array $regions = [
        'ww', 'cl', 'co', 'cz', 'dk',
        'eg', 'fi', 'fr', 'de', 'in',
        'ie', 'it', 'mx', 'no', 'ph',
        'pl', 'pt', 'sa', 'sg', 'za',
        'es', 'se', 'tr', 'ae', 'gb'
    ];

    /**
     * @var string|null $client_ip IP address of a user device.
     * You are advised to pass it for localization when connecting to the Search Kit server.
     */
    private ?string $client_ip = '127.0.0.1';

    /** @var string|null $request_id .Unique ID of a request. */
    private ?string $request_id;

    public function __construct( array|string $config ) {
        parent::__construct( $config );

        /* Obtain an access-token. */
        $account_kit = new AccountKit( $config );
        $this->access_token = $account_kit->get_access_token();

        // $this->base_url = Constants::SEARCH_KIT_BASE_URL;
        $this->base_url = Constants::SEARCH_KIT_BASE_URL_EU;
        if (isset($config['base_url'])) {$this->base_url = $config['base_url'];}
        $this->request_id = uniqid('hms_');
        $this->post_init();
    }

    /** Unset properties irrelevant to the child class. */
    protected function post_init(): void {
        unset($this->oauth2_client_secret, $this->oauth2_api_scope, $this->oauth2_redirect_url);
        unset($this->token_expiry, $this->refresh_token, $this->id_token, $this->package_name, $this->product_id);
        unset($this->agc_client_id, $this->agc_client_secret);
        unset($this->developer_id, $this->project_id);
        unset($this->api_key, $this->api_signature);

        $urls = [Constants::SEARCH_KIT_BASE_URL, Constants::SEARCH_KIT_BASE_URL_EU];
        if (! in_array($this->base_url, $urls)) {
            throw new \InvalidArgumentException('SearchKit permits these base_url values: '. implode(', ', $urls));
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
            "X-Kit-RequestID" => $this->request_id
        ];
    }

    private function query( string $search_url, string $keyword, string $language='en', string $region='ww', int $page_number=1, int $results=10 ): bool|\stdClass {
        if (! in_array($language, $this->languages)) {
            throw new \InvalidArgumentException('Supported languages: '.implode(', ', $this->languages));
        }
        if (! in_array($region, $this->regions)) {
            throw new \InvalidArgumentException('Supported regions: '.implode(', ', $this->regions));
        }
        $query = ['q' => $keyword, 'lang' => $language, 'sregion' => $region, 'pn' => $page_number, 'ps' => $results];
        return $this->request( 'GET', $this->base_url . $search_url, $this->auth_header(), $query);
    }

    /**
     * Searching for a Web Page
     * @param string $keyword Search keyword.
     * @param string $language Supported search languages. The default value is en.
     * @param string $region Supported search regions. The default value is ww.
     * @param int $page_number Number of a search result page. The value ranges from 1 to 100, and the default value is 1.
     * @param int $results Number of search results on a page. The value ranges from 1 to 100, and the default value is 10.
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/web-search-0000001056849539">Searching for a Web Page</a>
     */
    public function web_search( string $keyword, string $language='en', string $region='ww', int $page_number=1, int $results=10 ): \stdClass {
        return $this->query( Constants::SEARCH_KIT_WEB_SEARCH_URL, $keyword, $language, $region, $page_number, $results);
    }

    /**
     * Searching for an Image
     * @param string $keyword Search keyword.
     * @param string $language Supported search languages. The default value is en.
     * @param string $region Supported search regions. The default value is ww.
     * @param int $page_number Number of a search result page. The value ranges from 1 to 100, and the default value is 1.
     * @param int $results Number of search results on a page. The value ranges from 1 to 100, and the default value is 10.
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/image-search-0000001057330814">Searching for an Image</a>
     */
    public function image_search( string $keyword, string $language='en', string $region='ww', int $page_number=1, int $results=10 ): \stdClass {
        return $this->query( Constants::SEARCH_KIT_IMAGE_SEARCH_URL, $keyword, $language, $region, $page_number, $results);
    }

    /**
     * Searching for a Video
     * @param string $keyword Search keyword.
     * @param string $language Supported search languages. The default value is en.
     * @param string $region Supported search regions. The default value is ww.
     * @param int $page_number Number of a search result page. The value ranges from 1 to 100, and the default value is 1.
     * @param int $results Number of search results on a page. The value ranges from 1 to 100, and the default value is 10.
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/video-search-0000001057330836">Searching for a Video</a>
     */
    public function video_search( string $keyword, string $language='en', string $region='ww', int $page_number=1, int $results=10 ): \stdClass {
        return $this->query( Constants::SEARCH_KIT_VIDEO_SEARCH_URL, $keyword, $language, $region, $page_number, $results);
    }

    /**
     * Searching for News
     * @param string $keyword Search keyword.
     * @param string $language Supported search languages. The default value is en.
     * @param string $region Supported search regions. The default value is ww.
     * @param int $page_number Number of a search result page. The value ranges from 1 to 100, and the default value is 1.
     * @param int $results Number of search results on a page. The value ranges from 1 to 100, and the default value is 10.
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/news-search-0000001055690931">Searching for News</a>
     */
    public function news_search( string $keyword, string $language='en', string $region='ww', int $page_number=1, int $results=10 ): \stdClass {
        return $this->query( Constants::SEARCH_KIT_NEWS_SEARCH_URL, $keyword, $language, $region, $page_number, $results);
    }
}
