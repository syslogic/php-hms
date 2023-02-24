<?php /** @noinspection PhpUnused */
namespace HMS\AppGallery\Project;

use HMS\AppGallery\Connect;
use HMS\AppGallery\Constants;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Class HMS AppGallery Connect Project Wrapper
 *
 * Note: This API supports only the OAuth client mode.
 *
 * @author Martin Zeitler
 */
class Project extends Connect {

    /** Constructor */
    public function __construct( array|string $config ) {
        parent::__construct( $config );
        $this->base_url = Constants::CONNECT_API_BASE_URL;
        if (isset($config['base_url'])) {$this->base_url = $config['base_url'];}

        if (is_array($config) && isset($config['access_token'])) {
            $this->access_token = $config['access_token'];
        } else {
            throw new \InvalidArgumentException('Project API requires an user access token.');
        }
    }

    /**
     * Provide HTTP request headers as array.
     * @param bool $team_admin does nothing.
     */
    #[ArrayShape(['Content-Type' => 'string', 'oauth2Token' => 'string'])]
    protected function auth_headers( bool $team_admin=true ): array {
        return [
            'Content-Type' => 'application/json;charset=utf-8',
            'oauth2Token' => $this->access_token
        ];
    }

    /** The certificate fingerprint cannot contain colons (:). */
    private function strip_colons( string $fingerprint ): string {
        if (! str_contains($fingerprint, ':')) {return $fingerprint;}
        else {return str_replace(':', '', $fingerprint);}
    }

    /**
     * This is the only one endpoint which works without requesting any additional API scopes;
     * others won't function despite having requested: https://www.huawei.com/auth/agc/project.
     * @link https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-getteamlist-0000001158245075 Obtaining the Team List
     */
    public function team_list(): \stdClass {
        $url = Constants::CONNECT_API_BASE_URL.Constants::PROJECT_API_TEAM_LIST_URL;
        return $this->request('GET', $url, $this->auth_headers() );
    }

    /** @link https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-appbriefinfo-0000001111845106 Obtaining App Brief Information */
    public function app_brief_info( int $team_id, string $package_names ): \stdClass {
        $url = $this->base_url.Constants::PROJECT_API_APP_BRIEF_INFO_URL;
        $headers = $this->auth_headers();
        $headers['userID'] = $team_id;
        $payload = ['packageNames' => $package_names];
        return $this->request('GET', $url, $headers, $payload );
    }

    /** @link https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-getconfigfile-0000001158365065 Obtaining the Configuration File */
    public function app_config_file( int $team_id, int $app_id ): \stdClass {
        $url = $this->base_url.Constants::PROJECT_API_CONFIG_FILE_URL;
        $headers = $this->auth_headers(true);
        $payload = ['appId' => $app_id];
        return $this->request('GET', $url, $headers, $payload );
    }

    /** @link https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-addappfingerprint-0000001111685218 Adding a Certificate Fingerprint */
    public function add_certificate_fingerprint( int $team_id, int $developer_id, int $app_id, string $key_fingerprint ): \stdClass {
        $url = $this->base_url.Constants::PROJECT_API_FINGERPRINT_URL . $app_id;
        $headers = $this->auth_headers();
        $headers['teamId'] = $team_id; // ID of the team account to which an app belongs?
        $headers['uid'] = $developer_id; // Developer account ID
        $payload = ['addCertFingerprints' => $this->strip_colons($key_fingerprint)];
        return $this->request('PUT', $url, $headers, $payload );
    }

    /** @link https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-queryappfingerprint-0000001158245077 Querying the Certificate Fingerprint and App Secret */
    public function get_certificate_fingerprint( int $team_id, int $developer_id, int $app_id ): \stdClass {
        $url = $this->base_url.Constants::PROJECT_API_FINGERPRINT_URL . $app_id;
        $headers = $this->auth_headers();
        $headers['teamId'] = $team_id;
        $headers['uid'] = $developer_id;
        return $this->request('GET', $url, $headers );
    }

    /** @link https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-queryservice-0000001111845108 Querying Service Enabling Status */
    public function service_status(  int $project_id, int $app_id ): \stdClass {
        $url = $this->base_url.Constants::PROJECT_API_SERVICE_STATUS_URL;
        $headers = $this->auth_headers();
        $payload = ['projectId' => $project_id, 'appId' => $app_id];
        return $this->request('GET', $url, $headers, $payload );
    }

    /** @link https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-queryprojectdetail-0000001158365067 Querying Project Details and Apps Under the Project */
    public function project_details( int $project_id,  bool $query_apps=false ): \stdClass {
        $url = $this->base_url.Constants::PROJECT_API_PROJECT_URL . $project_id;
        $headers = $this->auth_headers();
        $payload = ['queryFlag' => $query_apps ? 1 : 0];
        return $this->request('GET', $url, $headers, $payload );
    }

    /** @link https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-queryprojectlist-0000001111685220 Querying the Project List */
    public function project_list( int $team_id, int $from_page=1, int $page_size=100 ): \stdClass {
        $url = $this->base_url.Constants::PROJECT_API_PROJECTS_URL;
        $headers = $this->auth_headers();
        $headers['teamId'] = $team_id;
        $payload = ['fromPage' => $from_page, 'pageSize' => $page_size];
        return $this->request('GET', $url, $headers, $payload );
    }
}
