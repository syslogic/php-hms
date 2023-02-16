<?php
namespace Tests;

use HMS\AppGallery\Constants;
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
    private static ?string $package_path = 'resources/';
    private static ?string $auth_code = null;
    private static ?string $upload_url = null;

    private static ?string $package_dest_url = null;
    private static ?string $package_file_name = null;
    private static int $package_file_size = 0;

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();

        self::$package_file_name = preg_grep('~\.(apk|aab)$~', scandir(self::$package_path))[3];
        self::$package_path .= self::$package_file_name;

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
        $result = self::$client->request_file_upload_url('aab');
        self::assertTrue( property_exists( $result, 'code' ) && $result->code == 0, $result->message );
        self::assertTrue( property_exists( $result, 'message' ) && $result->message == 'success' );
        self::assertTrue( property_exists( $result, 'uploadUrl' ) && is_string($result->uploadUrl) );
        self::assertTrue( property_exists( $result, 'authCode' ) && is_string($result->authCode) );
        self::$upload_url = $result->uploadUrl;
        self::$auth_code = $result->authCode;
        echo print_r($result, true);
    }

    /** Uploading a File */
    public function test_upload_file() {
        self::assertTrue(self::$upload_url != null || self::$auth_code != null );
        $result = self::$client->upload_file( self::$upload_url, self::$auth_code, self::$package_path );
        self::assertTrue( property_exists( $result, 'resultCode' ) &&  $result->resultCode == 0 );
        self::assertTrue( property_exists( $result, 'UploadFileRsp' ) &&  is_object($result->UploadFileRsp) );
        self::assertTrue( property_exists( $result->UploadFileRsp, 'ifSuccess' ) &&  $result->UploadFileRsp->ifSuccess == 1 );
        self::assertTrue( property_exists( $result->UploadFileRsp, 'fileInfoList' ) &&  is_array($result->UploadFileRsp->fileInfoList) );
        self::$package_dest_url = $result->UploadFileRsp->fileInfoList[0]->fileDestUlr;
        self::$package_file_size = $result->UploadFileRsp->fileInfoList[0]->size;
        echo print_r($result->UploadFileRsp->fileInfoList[0], true);
    }

    /** Updating App File Information */
    public function test_update_file_info() {
        self::assertTrue(self::$package_dest_url != null );
        $result = self::$client->update_file_info( self::$package_path, self::$package_dest_url, self::$package_file_size );
        if ($result->code == 204144662) {
            $cause = "Please enable App Signing in order to publish App Bundle format (" . self::$package_path . ").\n";
            $cause .= "In case the following URL does not lead to the expected package, validate the configuration.\n";
            $cause .= str_replace("{appId}", self::$oauth2_client_id, Constants::PUBLISH_API_CERTIFICATES."\n");
            self::markTestIncomplete( $cause );
        } else {
            self::assertTrue( property_exists( $result, 'pkgVersion' ) &&  is_array($result->pkgVersion) );
            echo print_r($result->pkgVersion, true);
        }
    }

    public function test_submit_release() {
        $cause = 'Release Submission Test being skipped for now.';
        self::markTestSkipped( $cause );
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
            'lang'        => 'en-US',
            'appName'     => '',
            'appDesc'     => '',
            'briefInfo'   => '',
            'newFeatures' => ''
        ] );
        self::assertTrue( $item->validate() );
        self::assertTrue( is_array( $item->asArray() ) );
        echo print_r($item->asObject(), true);
    }
}
