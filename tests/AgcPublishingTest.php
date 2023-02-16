<?php
namespace Tests;

use HMS\AppGallery\Model\AppInfo;
use HMS\AppGallery\Model\AppLanguageInfo;
use HMS\AppGallery\Publishing\Publishing;

/**
 * HMS AppGallery Connect Publishing API Test
 *
 * @author Martin Zeitler
 */
class AgcPublishingTest extends BaseTestCase {

    private static ?Publishing $client;

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        self::$client = new Publishing( [
            'project_id'                => self::$project_id,
            'agc_team_client_id'        => self::$agc_team_client_id,
            'agc_team_client_secret'    => self::$agc_team_client_secret,
            'agc_project_client_id'     => self::$agc_project_client_id,
            'agc_project_client_secret' => self::$agc_project_client_secret,
            'oauth2_client_id'          => self::$oauth2_client_id,
            'debug_mode'                => self::$debug_mode
        ] );
    }

    /** Test: On Release Submission Callback. */
    public function test_on_submission_callback() {
        try {
            self::assertTrue(self::$client->on_submission_callback());
        } catch (\InvalidArgumentException $e) {
            self::assertTrue( $e instanceof \InvalidArgumentException);
        }
    }

    /** Obtaining the File Upload URL */
    public function test_request_file_upload_url() {
        $result = self::$client->request_file_upload_url();
        echo print_r($result, true);
        self::assertTrue( property_exists($result, 'code' ) && $result->code == 0, $result->message );
        self::assertTrue( property_exists($result, 'message' ) && $result->message == 'success' );
        self::assertTrue( property_exists($result, 'uploadUrl' ) && is_string($result->uploadUrl) );
        self::assertTrue( property_exists($result, 'authCode' ) && is_string($result->authCode) );
        echo print_r($result, true);
    }

    /** Uploading a File */
    public function test_upload_file() {
        self::assertTrue(false, 'TODO: Uploading a File' );
    }

    /** Updating App File Information */
    public function test_update_file_info() {
        self::assertTrue(false, 'TODO: Updating App File Information' );
    }

    /** Test: Model AppInfo. */
    public function test_model_app_info() {
        $item = new AppInfo( [

        ] );
        self::assertTrue( $item->validate() );
        self::assertTrue( is_array( $item->asArray() ) );
        echo print_r($item->asObject(), true);
    }

    /** Test: Model AppInfo. */
    public function test_model_app_language_info() {
        $item = new AppLanguageInfo( [

        ] );
        self::assertTrue( $item->validate() );
        self::assertTrue( is_array( $item->asArray() ) );
        echo print_r($item->asObject(), true);
    }
}
