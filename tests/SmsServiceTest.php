<?php
namespace Tests;

use HMS\SmsService\SmsService;

/**
 * HMS SmsService Test
 *
 * @author Martin Zeitler
 */
class SmsServiceTest extends BaseTestCase {

    private static ?SmsService $client;

    private static string $sender_channel_id = 'csms12345678';

    private static string $status_report_success = 'sequence=1&total=1&updateTime=2018-10-31T08%3A43%3A41Z&source=2&smsMsgId=2ea20735-f856-4376-afbf-570bd70a46ee_11840135&status=DELIVRD';
    private static string $status_report_failure = 'orgCode=E200027&sequence=1&total=1&updateTime=2018-10-31T08%3A43%3A41Z&source=2&smsMsgId=2ea20735-f856-4376-afbf-570bd70a46ee_11840135&status=RTE_ERR';
    private static string $upstream_sms_message = 'from=%2B8615123456789&to=10691002019&body=********&smsMsgId=9692b5be-c427-4525-8e73-cf4a6ac5b3f7';

    private static string $receivers = '+8615123456789,+8615234567890';
    private static string $template_id = '8ff55eac1d0b478ab3c06c3c6a492300';
    private static array $template_params_01 = ['123456'];
    private static array $template_params_02 = ['234567'];

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        self::$client = new SmsService( self::get_config() );
        self::assertTrue( self::$client->is_ready(), self::CLIENT_NOT_READY );
    }

    /** Test: Send SMS. */
    public function test_send_sms() {
        $result = self::$client->send_sms(
            self::$sender_channel_id,
            '+8615123456789,+8615234567890',
            self::$template_id,
            self::$template_params_01
        );
        self::assertTrue( $result->code == 200 );
    }

    /** Test: Send SMS. */
    public function test_send_batch_sms() {
        $result = self::$client->send_batch_sms(
            self::$sender_channel_id, [
                self::$client->get_diff_sms(explode(',', self::$receivers), self::$template_id, self::$template_params_01),
                self::$client->get_diff_sms(explode(',', self::$receivers), self::$template_id, self::$template_params_02)
            ],
            '',
            ''
        );
        self::assertTrue( $result->code == 200 );
    }

    /** Test: Parse the status report data. */
    public function test_parse_status_report_success() {
        $result = self::$client->parse_status_report(self::$status_report_success);
        self::assertTrue($result['success'] === true);
    }

    /** Test: Parse the status report data. */
    public function test_parse_status_report_failure() {
        $result = self::$client->parse_status_report(self::$status_report_failure);
        self::assertTrue($result['success'] === false);
    }

    /** Test: Parse an uplink SMS message. */
    public function test_parse_uplink_message() {
        $result = self::$client->parse_uplink_message(self::$upstream_sms_message);
        self::assertTrue($result['body'] === '********');
    }
}
