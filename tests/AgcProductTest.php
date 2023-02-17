<?php
namespace Tests;

use HMS\AppGallery\Constants;
use HMS\AppGallery\Product\Product;

/**
 * HMS AppGallery Connect Product API Test
 *
 * @author Martin Zeitler
 */
class AgcProductTest extends BaseTestCase {

    private static ?Product $client;

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        self::$debug_mode = true;
        self::$client = new Product([
            'project_id'                => self::$project_id,
            'oauth2_client_id'          => self::$oauth2_client_id,
            'agc_team_client_id'        => self::$agc_team_client_id,
            'agc_team_client_secret'    => self::$agc_team_client_secret,
            'agc_project_client_id'     => self::$agc_project_client_id,
            'agc_project_client_secret' => self::$agc_project_client_secret,
            'agc_app_client_id'         => self::$agc_app_client_id,
            'agc_app_client_secret'     => self::$agc_app_client_secret,
            'debug_mode'                => self::$debug_mode
        ]);
        self::assertNotFalse(self::$client->is_ready());
    }

    /** Test: Creating a Product. */
    public function test_add_product() {
        $result = self::$client->add_product( [
            "productNo" => uniqid('product_'),
            "appId" => self::$oauth2_client_id,
            "productName" => "Create product information",
            "purchaseType" => "consumable",
            "status"=> "inactive",
            "currency"=> "CNY",
            "country"=> "CN",
            "defaultLocale"=> "zh-CN",
            "defaultPrice"=> "4000",
            "productDesc"=> "Test product description",
            "languages"=> [ $this->get_language() ]
        ]);
        echo str_replace("{appId}", self::$oauth2_client_id, Constants::PMS_API_PRODUCT_MANAGEMENT."\n");
        self::assertTrue( property_exists( $result, 'error' ) && $result->error->errorCode == 0 );
    }

    private function get_language(): \stdClass {
        $locale = new \stdClass();
        $locale->locale = "en_US";
        $locale->productName = "Create product information";
        $locale->productDesc = "Test product description";
        return $locale;
    }
}
