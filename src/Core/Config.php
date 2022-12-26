<?php /** @noinspection PhpUnused */

/** @noinspection PhpPropertyOnlyWrittenInspection */
namespace HMS\Core;

use stdClass;

/**
 * Class HMS Core Configuration
 *
 * @author Martin Zeitler
 */
class Config {

    private string $config_version = "3.0";
    private string $region = "DE";

    private array|object $service_url = [
        'collector' => "datacollector-dre.dt.hicloud.com,datacollector-dre.dt.dbankcloud.cn",
        'mlservice' => "ml-api-dre.ai.dbankcloud.com,ml-api-dre.ai.dbankcloud.cn",
        'search'    => "https://search-dre.cloud.huawei.com", // these have a protocol, the others have a comma.
        'storage'   => "https://ops-dre.agcstorage.link" // these have a protocol, the others have a comma.
    ];

    private string|null $client_secret = null;
    private string|null $app_secret = null;
    protected string|null $package_name = null;

    /** Possibly for MapKit / LocationKit related. */
    protected string|null $api_key = null;

    /** AnalyticsKit related. */
    protected int $project_id = 0;
    protected int $product_id = 0;
    protected int $client_id = 0;
    protected int $app_id = 0;

    private stdClass $client;
    private stdClass $oauth_client;
    private stdClass $app_info;
    private stdClass $appInfos;

    /** Constructor; initialize by filename. */
    public function __construct( string|null $config_file ) {
        $this->service_url = (object) $this->service_url;
        if ( $config_file == null && is_string( getenv('HUAWEI_APPLICATION_CREDENTIALS') )) {
            $config_file = getenv('HUAWEI_APPLICATION_CREDENTIALS');
        }
        if (is_string( $config_file ) && file_exists( $config_file ) && is_readable( $config_file )) {
            $this->load_config_file( $config_file );
        }
    }

    /** Load agconnect-services.json. */
    private function load_config_file( string $config_file ) {
        $config = json_decode(file_get_contents( $config_file ));
        if ( is_object( $config )) {
            if ( property_exists( $config,'configuration_version' )) {
                $this->config_version = (string) $config->configuration_version;
            }
            if ( property_exists( $config, 'region' )) {
                $this->region  = (string) $config->region;
            }
            if ( property_exists( $config, 'service' )) {
                if ( property_exists( $config->service, 'analytics' )) {
                    $this->service_url->collector = (string) $config->service->analytics->collector_url;
                }
                if ( property_exists( $config->service, 'search' )) {
                    $this->service_url->search = (string) $config->service->search->url;
                }
                if ( property_exists( $config->service, 'cloudstorage' )) {
                    $this->service_url->storage = (string) $config->service->cloudstorage->storage_url;
                }
                if ( property_exists( $config->service, 'ml' )) {
                    $this->service_url->mlservice = (string) $config->service->ml->mlservice_url;
                }
            }
            if ( property_exists( $config, 'client' )) {
                $this->app_id        =    (int) $config->client->app_id;
                $this->app_secret    = (string) getenv('HUAWEI_OAUTH2_CLIENT_SECRET'); // not contained in the JSON.
                $this->package_name  = (string) $config->client->package_name;
                $this->project_id    =    (int) $config->client->project_id;
                $this->product_id    =    (int) $config->client->product_id;
                $this->client_id     =    (int) $config->client->client_id;
                $this->client_secret = (string) $config->client->client_secret;
                $this->api_key       = (string) $config->client->api_key;
            }
        }
    }

    public function get_project_id(): int {
        return $this->project_id;
    }
    public function get_product_id(): int {
        return $this->product_id;
    }
    public function get_client_id(): int {
        return $this->client_id;
    }
    public function get_app_id(): int {
        return $this->app_id;
    }
}
