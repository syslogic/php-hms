<?php /** @noinspection PhpUnused */
namespace HMS\AppGallery\Project;

use HMS\AppGallery\Connect;
use HMS\AppGallery\Constants;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Class HMS AppGallery Connect Project Wrapper
 *
 * @author Martin Zeitler
 */
class Project extends Connect {

    /** Constructor */
    public function __construct( array|string $config ) {
        parent::__construct( $config );
        $this->base_url = Constants::CONNECT_API_BASE_URL;
        if (isset($config['base_url'])) {$this->base_url = $config['base_url'];}
        $this->access_token = $this->get_access_token(true);
    }

    /**
     * Provide HTTP request headers as array.
     *@param bool $team_admin It determines which client_id to send.
     */
    #[ArrayShape(['Content-Type' => 'string', 'Authorization' => 'string', 'client_id' => 'string'])]
    protected function auth_headers( bool $team_admin=true ): array {
        return [
            'Content-Type' => 'application/json;charset=utf-8',
            'oauth2Token' => $this->access_token
        ];
    }


    /** @link https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-iapexport-0000001158365061 Obtaining the Download and Installation Report URL */
    public function team_list(): \stdClass {
        $url = $this->base_url.Constants::PROJECT_API_TEAM_LIST_URL;
        $headers = $this->auth_headers(true);
        return $this->request('GET', $url, $headers );
    }
}
