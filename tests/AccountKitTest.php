<?php
namespace Tests;

use HMS\AccountKit\AccountKit;
use PHPUnit\Framework\TestCase;

/**
 * HMS AccountKit Test
 *
 * @author Martin Zeitler
 */
class AccountKitTest extends BaseTestCase {

    private static AccountKit|null $client;

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        self::$client = new AccountKit( [
            'client_id'     => (int)    getenv('HUAWEI_CLIENT_ID'),
            'client_secret' => (string) getenv('HUAWEI_CLIENT_SECRET')
        ] /* the default version is 3 */ );
    }

    /** Test: oAuth2 Token Refresh. */
    public function test_ready() {
        self::assertTrue( self::$client->is_ready(), 'The client is not ready.');
    }
}
