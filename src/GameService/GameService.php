<?php
namespace HMS\GameService;

use HMS\Core\Wrapper;

/**
 * Class HMS GameService Wrapper
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/verify-login-signature-0000001050123503">GameService</a>
 * @author Martin Zeitler
 */
class GameService extends Wrapper {

    public function __construct( array|string $config ) {
        parent::__construct( $config, 3 );
    }
}
