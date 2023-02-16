<?php /** @noinspection PhpPropertyOnlyWrittenInspection */

namespace HMS\AppGallery;

use HMS\AppGallery\AuthService\AuthService;
use HMS\AppGallery\Product\Product;
use HMS\AppGallery\Project\Project;
use HMS\AppGallery\Publishing\Publishing;
use HMS\Core\Wrapper;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Class HMS AppGallery Connect Wrapper
 *
 * @link https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-Guides/agcapi-getstarted-0000001111845114 Getting Started
 * @author Martin Zeitler
 */
abstract class Connect extends Wrapper {

    protected string $base_url = Constants::CONNECT_API_BASE_URL;

    /** Constructor */
    public function __construct( array|string $config ) {
        parent::__construct( $config );
        $this->post_init();
    }

    /** Unset properties irrelevant to the child class. */
    protected function post_init(): void {
        unset($this->client_id, $this->client_secret);
        unset($this->package_name, $this->refresh_token);
        unset($this->api_key, $this->api_signature);
        $urls = [Constants::CONNECT_API_BASE_URL, Constants::CONNECT_API_BASE_URL_EU, Constants::CONNECT_API_BASE_URL_AS, Constants::CONNECT_API_BASE_URL_RU];
        if (! in_array($this->base_url, $urls)) {
            throw new \InvalidArgumentException('AppGallery Connect API permits these base_url values: '. implode(', ', $urls));
        }
    }

    /**
     * Obtaining a Token, the AgConnect Version.
     *
     * @link https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-obtain_token-0000001158365043 Obtaining a Token
     * @param bool $team_admin It determines which access level to obtain.
     * @return string|null the token string only.
     */
    protected function get_access_token( bool $team_admin=false ): ?string {
        $url = $this->base_url.Constants::CONNECT_API_OAUTH2_TOKEN_URL;
        $result = $this->request( 'POST',$url, $this->request_headers(), [
            'grant_type'    => 'client_credentials',
            'client_id'     => $team_admin ? $this->agc_team_client_id : $this->agc_project_client_id,
            'client_secret' => $team_admin ? $this->agc_team_client_secret : $this->agc_project_client_secret
        ] );
        if (property_exists($result, 'access_token')) {
            return $result->access_token;
        }
        if (property_exists($result, 'message')) {
            echo $result->message;
        }
        return null;
    }

    /**
     * Provide HTTP request headers as array.
     *@param bool $team_admin It determines which client_id to send.
     */
    #[ArrayShape(['Content-Type' => 'string', 'Authorization' => 'string', 'client_id' => 'string'])]
    protected function auth_headers( bool $team_admin=false ): array {
        return [
            'Content-Type' => 'application/json;charset=utf-8',
            'Authorization' => "Bearer $this->access_token",
            'client_id' => $team_admin ? $this->agc_team_client_id : $this->agc_project_client_id
        ];
    }

    private function config(): array {
        return [
            'project_id'                => $this->project_id,
            'agc_project_client_id'     => $this->agc_project_client_id,
            'agc_project_client_secret' => $this->agc_project_client_secret,
            'debug_mode'                => $this->debug_mode
        ];
    }
}
