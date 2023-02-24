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
    private static ?string $subscription_group_id;
    private static string $subscription_group_name = 'Test Subscription Group';
    private static ?string $product_promotion_id;
    private static ?string $product_promotion_title = 'Test Product Promotion';
    private static int $plus_one_week;
    private static int $plus_two_weeks;

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        echo 'AppGallery: ';
        echo str_replace("{appId}", self::$oauth2_client_id, Constants::PMS_API_PRODUCT_MANAGEMENT."\n\n");
        self::$product_id = uniqid('product_');
        self::$plus_one_week  = (time() +  7 * 86400) * 1000;
        self::$plus_two_weeks = (time() + 14 * 86400) * 1000;
        self::$debug_mode = true;

        self::$client = new Product( [
            'project_id'                => self::$project_id,
            'oauth2_client_id'          => self::$oauth2_client_id,
            'agc_team_client_id'        => self::$agc_team_client_id,
            'agc_team_client_secret'    => self::$agc_team_client_secret,
            'agc_project_client_id'     => self::$agc_project_client_id,
            'agc_project_client_secret' => self::$agc_project_client_secret,
            'agc_app_client_id'         => self::$agc_app_client_id,
            'agc_app_client_secret'     => self::$agc_app_client_secret,
            'debug_mode'                => self::$debug_mode
        ] );
        self::assertNotFalse(self::$client->is_ready());
    }

    private function get_language(): \stdClass {
        $locale = new \stdClass();
        $locale->locale = "en-US";
        $locale->productName = "Create product information";
        $locale->productDesc = "Test product description";
        return $locale;
    }

    /**
     * Test: Creating a Product.
     * @link https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-pms-productinfo-0000001162468157 ProductInfo
     */
    public function test_create_product() {
        $result = self::$client->create_product( [
            "appId" => self::$oauth2_client_id,
            "productNo" => self::$product_id,
            "purchaseType" => "consumable",
            "status"=> "inactive",
            "productName" => "Test consumable",
            "productDesc"=> "Test product description",
            "currency"=> "EUR",
            "country"=> "DE",
            "defaultLocale"=> "de_DE",
            "defaultPrice"=> "999",
            "languages"=> [ $this->get_language() ]
        ]);
        self::assertTrue( property_exists( $result, 'error' ) && $result->error->errorCode == 0 );
    }

    /**
     * Test: Updating a Product.
     * @link https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-pms-productinfo-0000001162468157 ProductInfo
     */
    public function test_update_product() {
        $result = self::$client->update_product( [
            "appId" => self::$oauth2_client_id,
            "productNo" => self::$product_id,
            "purchaseType" => "consumable",
            "status"=> "inactive",
            "productName" => "Test consumable (updated)",
            "productDesc"=> "Updated product description",
            "currency"=> "EUR",
            "country"=> "DE",
            "defaultLocale"=> "de_DE",
            "defaultPrice"=> "1999",
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

    /**
     * Test: Creating a Product Subscription Group.
     * @link https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-pms-pgroupinfo-0000001115868358 ProductGroupInfo
     */
    public function test_create_product_subscription_group() {
        $result = self::$client->create_product_subscription_group( self::$subscription_group_name );
        self::assertTrue( property_exists( $result, 'error' ) && $result->error->errorCode == 0 );
        self::assertTrue( property_exists( $result, 'result' ) && is_string($result->result) );
        self::$subscription_group_id = $result->result;
        echo 'Group "'. self::$subscription_group_name .'" ID: ' . self::$subscription_group_id . '.';
    }

    /** Test: Updating a Product Subscription Group. */
    public function test_update_product_subscription_group() {
        self::assertTrue( isset(self::$subscription_group_id) );
        $result = self::$client->update_product_subscription_group( self::$subscription_group_id, self::$subscription_group_name );
        self::assertTrue( property_exists( $result, 'error' ) && $result->error->errorCode == 0 );
    }

    /** Test: Querying Product Subscription Groups. */
    public function test_product_subscription_groups() {
        $result = self::$client->product_subscription_groups();
        self::assertTrue( property_exists( $result, 'error' ) && $result->error->errorCode == 0 );
        self::assertTrue( property_exists($result, 'simpleGroups' ) && is_array($result->simpleGroups) );
        echo print_r($result->simpleGroups, true);
    }

    /**
     * Test: Creating a Product Promotion.
     * @link https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-pms-ppromotioninfo-0000001116028268 ProductPromotionInfo
     */
    public function test_create_product_promotion() {
        $result = self::$client->create_product_promotion( [
            'productNo' => self::$product_id,
            'promotionTitle' => self::$product_promotion_title,
            'startDate' => self::$plus_one_week,
            'endDate' => self::$plus_two_weeks,
            'strategy' => 'introductory', // trial or introductory.
            "currency"=> "EUR",           // required for: introductory.
            "country"=> "DE",             // required for: introductory.
            "defaultLocale"=> "de_DE",    // required for: introductory.
            "defaultPrice"=> "499",       // required for: introductory.
            'status' => 'active'
        ] );

        self::assertTrue( property_exists( $result, 'error' ) && $result->error->errorCode == 0 );
        self::assertTrue( property_exists( $result, 'promotionId' ) && is_string($result->promotionId) );
        self::$product_promotion_id = $result->promotionId;
        echo 'Product "'. self::$product_id .'" Promotion ID: ' . self::$product_promotion_id . '.';
    }

    /** Test: Updating a Product Promotion. */
    public function test_update_product_promotion() {
        $result = self::$client->update_product_promotion([
            'promotionId' => self::$product_promotion_id,
            'productNo' => self::$product_id,
            'promotionTitle' => self::$product_promotion_title,
            'startDate' => self::$plus_one_week,
            'endDate' => self::$plus_two_weeks,
            'strategy' => 'introductory', // trial or introductory.
            "currency"=> "EUR",           // required for: introductory.
            "country"=> "DE",             // required for: introductory.
            "defaultLocale"=> "de_DE",    // required for: introductory.
            "defaultPrice"=> "899",       // required for: introductory.
            'status' => 'active'
        ] );
        self::assertTrue( property_exists( $result, 'error' ) && $result->error->errorCode == 0 );
        echo print_r($result, true);
    }

    /** Test: Querying Promotion Details of a Product. */
    public function test_product_promotion_info() {
        self::assertTrue( isset(self::$product_promotion_id) );
        $result = self::$client->product_promotion_info( self::$product_promotion_id );
        self::assertTrue( property_exists( $result, 'error' ) && $result->error->errorCode == 0 );
        echo print_r($result, true);
    }

    /** Test: Searching Product Promotions by Criteria. */
    public function test_product_promotions() {
        $result = self::$client->product_promotions( [] );
        self::assertTrue( property_exists( $result, 'error' ) && $result->error->errorCode == 0 );
        self::assertTrue( property_exists($result, 'productPromotions' ) && is_array($result->productPromotions) );
        self::assertTrue( property_exists($result, 'totalNumber' ) && is_int($result->totalNumber) );
        echo print_r($result->productPromotions, true);
    }
}
