<?php /** @noinspection PhpUnused */
namespace HMS\GameService;

/**
 * Class HMS GameService Constants
 *
 * @author Martin Zeitler
 */
class Constants {

    /**
     * Note: Currently, this API does not support SSL two-way authentication.
     * Before sending an HTTPS request, you must disable SSL authentication.
     */
    public const GAME_SERVICE_BASE_URL  = "https://jos-api.cloud.huawei.com/gameservice/api/gbClientApi";

    public const CONNECT_DELIVERY_SUCCESS_URL  = "https://connect-api.cloud.huawei.com/api/dps/v1/usage/delivery/callback";

}
