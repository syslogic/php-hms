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
     * @param bool $team_admin It determines which client_id to send.
     */
    #[ArrayShape(['Content-Type' => 'string', 'Authorization' => 'string', 'client_id' => 'string'])]
    protected function auth_headers( bool $team_admin=true ): array {
        return [
            'Content-Type' => 'application/json;charset=utf-8',
            'oauth2Token' => $this->access_token
        ];
    }

    /** @link https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-getteamlist-0000001158245075 Obtaining the Team List */
    public function team_list(): \stdClass {
        $url = $this->base_url.Constants::PROJECT_API_TEAM_LIST_URL;
        $headers = $this->auth_headers(true);
        return $this->request('GET', $url, $headers );
    }

    /** @link https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-appbriefinfo-0000001111845106 Obtaining App Brief Information */
    public function app_brief_info( int $team_id ): \stdClass {
        $url = $this->base_url.Constants::PROJECT_API_APP_BRIEF_INFO_URL;
        $headers = $this->auth_headers(true);
        $headers['userID'] = $team_id;
        $payload = ['appId' => $this->oauth2_client_id];
        return $this->request('GET', $url, $headers, $payload );
    }
}
