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

    private static string $product_id;
    private static string $subscription_group_name = 'PHPUnit Group';

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {

        parent::setUpBeforeClass();
        echo str_replace("{appId}", self::$oauth2_client_id, Constants::PMS_API_PRODUCT_MANAGEMENT."\n");
        self::$product_id = uniqid('product_');
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

    private function get_language(): \stdClass {
        $locale = new \stdClass();
        $locale->locale = "en-US";
        $locale->productName = "Create product information";
        $locale->productDesc = "Test product description";
        return $locale;
    }

    /** Test: Creating a Product. */
    public function test_create_product() {
        $result = self::$client->create_product( [
            "appId" => self::$oauth2_client_id,
            "productNo" => self::$product_id,
            "purchaseType" => "consumable",
            "status"=> "inactive",
            "productName" => "Create product information",
            "productDesc"=> "Test product description",
            "currency"=> "EUR",
            "country"=> "DE",
            "defaultLocale"=> "de_DE",
            "defaultPrice"=> "2",
            "languages"=> [ $this->get_language() ]
        ]);
        self::assertTrue( property_exists( $result, 'error' ) && $result->error->errorCode == 0 );
    }

    /** Test: Creating a Product. */
    public function test_update_product() {
        $result = self::$client->update_product( [
            "appId" => self::$oauth2_client_id,
            "productNo" => self::$product_id,
            "purchaseType" => "consumable",
            "status"=> "inactive",
            "productName" => "Update product information",
            "productDesc"=> "Updated product description",
            "currency"=> "EUR",
            "country"=> "DE",
            "defaultLocale"=> "de_DE",
            "defaultPrice"=> "20",
            "languages"=> [ $this->get_language() ]
        ]);
        self::assertTrue( property_exists( $result, 'error' ) && $result->error->errorCode == 0 );
    }

    /** Test: Querying Details of a Product. */
    public function test_product_info() {
        $result = self::$client->product_info( self::$product_id );
        self::assertTrue( property_exists( $result, 'error' ) && $result->error->errorCode == 0 );
        self::assertTrue( property_exists($result, 'product' ) && is_object($result->product) );
        echo print_r($result->product, true);
    }

    /** Test: Creating a Product Subscription Group. */
    public function test_create_product_subscription_group() {
        $result = self::$client->create_product_subscription_group( self::$subscription_group_name );
        self::assertTrue( property_exists( $result, 'error' ) && $result->error->errorCode == 0 );
        self::assertTrue( property_exists( $result, 'result' ) && is_string($result->result) );
        echo 'Group "'. self::$subscription_group_name .'" ID: ' . $result->result . '.';
    }

    /** Test: Querying Product Subscription Groups. */
    public function test_product_subscription_groups() {
        $result = self::$client->product_subscription_groups();
        self::assertTrue( property_exists( $result, 'error' ) && $result->error->errorCode == 0 );
        self::assertTrue( property_exists($result, 'simpleGroups' ) && is_array($result->simpleGroups) );
        echo print_r($result->simpleGroups, true);
    }
}
