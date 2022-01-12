<?php
namespace HMS\Connect;

use HMS\Core\Model;
use stdClass;

/**
 * Class HMS Connect AppInfo
 *
 * @see https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-app-info-update-0000001111685198
 * @author Martin Zeitler
 */
class AppInfo extends Model {

    protected array $mandatory_fields = [];
    protected array $optional_fields  = [];

    /**
     * @var string $defaultLang (64) Default language of an app.
     * For details, please refer to Languages.
     * @see https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-reference-langtype-0000001158245079
     */
    private string $defaultLang = "en-US";

    /**
     * @var int $childType (4) Level-2 category of an app.
     * The ID is fixed. For details, please refer to App/Game Categories.
     * @see https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-reference-apptype-0000001158365069
     */
    private int $childType = 0;

    /**
     * @var int $grandChildType (4) Level-3 category of an app.
     * The ID is fixed. For details, please refer to App/Game Categories.
     * @see https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-reference-apptype-0000001158365069
     */
    private int $grandChildType = 0;

    /**
     * @var string $privacyPolicy (255) Privacy statement link.
     */
    private string $privacyPolicy = "https://*****.link";

    /**
     * @var string $appAdapters (16) Devices supported by an app.
     * Multiple values can be configured, for example, 1,2,3.
     * 1: Honor Cube
     * 2: TRON
     * 3: set-top box
     * 4: mobile phone
     * 5: tablet
     * 6: VR gadget
     * 7: Huawei Watch
     * 8: Vision
     * 9: router
     * 11: children's watch (Android)
     * 12: smartwatch (Android Wear)
     * This parameter is not recommended. Use the appAdapters attribute of the deviceTypes parameter instead.
     * For an app package that supports multiple device types, you can only use deviceTypes.
     */
    private string $appAdapters = "4,5";

    /**
     * @var int $appNetType (1) App networking type.
     * 1: standalone
     * 2: online
     */
    private int $appNetType = 1;

    /**
     * @var int $isFree (1) App payment type.
     * 1: free
     * 0: paid
     * If isFree is set to 1, the price and priceDetail parameters are invalid.
     */
    private int $isFree = 1;

    /**
     * @var string $price (255) App price, in {"countryCode":"price"} format.
     */
    private string $price = "{\"EUR\":\"0\"}";

    /**
     * @var string $priceDetail (8192) App price,
     * in [{"country":"CN","currency":"CNY","price":"18.00"},{{"country":"DE","currency":"EUR","price":"2.50"}}] format.
     */
    private string $priceDetail = "[]";

    /**
     * @var string $publishCountry (255) Code of a country/region where an app is released.
     */
    private string $publishCountry= "AF,AE,OM,PK,PS,BH,QA,KW,LB,SA,IQ,IL,JO,AU,MO,PG,PF,PH,FJ,KR,KH,CK,LA,MV,MY,AS,BD,MM,NR,NP,JP,LK,SB,TW,TH,TO,VU,BN,HK,SG,NZ,IN,ID,VN,AZ,GE,KZ,KG,MN,TJ,TM,UZ,AM,ALL,CN,AL,IE,EE,AD,AT,BG,BE,IS,BA,PL,DK,DE,RU,FR,FO,VA,FI,GL,NL,ME,CZ,HR,LV,LT,LI,LU,RO,MT,MK,MD,MC,NO,PT,SE,CH,RS,CY,SM,SK,SI,UA,ES,GR,HU,IT,GB,GI,BY,TR,DZ,EG,ET,AO,BJ,BW,BF,BI,GQ,TG,ER,CV,GM,CG,CD,DJ,GN,GW,GH,GA,ZW,CM,KM,CI,KE,LS,LR,LY,RE,RW,MG,MW,ML,YT,MU,MR,MA,MZ,NA,ZA,SS,NE,NG,SL,SN,SC,ST,SZ,SO,TZ,TN,UG,YE,ZM,TD,CF,AR,AW,AI,AG,BB,BS,PY,PA,BR,PR,BO,BZ,DO,EC,GF,CO,CR,GD,GP,GY,HT,AN,HN,KY,MQ,MS,PE,MX,NI,SV,LC,VC,SR,TT,GT,VE,UY,JM,VG,CL,CA";

    /**
     * @var string $contentRate (255) App rating, in JSON format.
     * Currently, only ratings specified by Huawei are supported, for example,
     * {"HW":"3+"}. For details about app ratings, please refer to App Ratings.
     * @see https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-reference-applevel-0000001111685222
     */
    private string $contentRate = "{\"HW\":\"3+\"}";

    /**
     * @var int $isAppForcedUpdate (1) Indicates whether an app is forcibly updated.
     * 0: no
     * 1: yes
     */
    private int $isAppForcedUpdate = 0;

    /**
     * @var int $hispaceAutoDown (1) Indicates whether to allow HUAWEI AppGallery to capture an app package from the Internet.
     * 0: no
     * 1: yes
     */
    private int $hispaceAutoDown = 0;

    /**
     * @var string $appTariffType (16) Type of an in-app purchase item.
     * Multiple values are supported. Use commas (,) to separate them, for example, 1,2,3.
     * 1: activation
     * 2: item
     * 3: unlocking a game level
     * 4: virtual coin
     * 5: paid chapter
     * 6: others
     * 7: course
     * 8: membership
     */
    private string $appTariffType = "6";

    /**
     * @var string $publicationNumber (50) Publication approval number.
     * This parameter applies only to game apps.
     */
    private string $publicationNumber = "";

    /**
     * @var string $cultureRecordNumber (50) Internet culture operation license (China only).
     * This parameter applies only to game apps.
     */
    private string $cultureRecordNumber = "";

    /**
     * @var string $developerNameCn (64) Chinese name of a developer.
     * This parameter can be modified only for developers on the trust-list.
     */
    private string $developerNameCn = "";

    /**
     * @var string $developerNameEn (64) English name of a developer.
     * This parameter can be modified only for developers on the trust-list.
     */
    private string $developerNameEn = "";

    /**
     * @var string $developerWebsite (255) Developer official website.
     */
    private string $developerWebsite = "";

    /**
     * @var int $familyShareTag (1) Indicates whether an app can be shared among family members.
     * 0: no
     * 1: yes
     */
    private int $familyShareTag = 0;

    /**
     * @var array $deviceTypes Device type information.
     * @see https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-app-info-update-0000001111685198#EN-US_TOPIC_0000001111685198__en-us_topic_0000001059070156_p17819165272318
     */
    private array $deviceTypes = [];

    /**
     * @var int $webGameFlag (1) Indicates whether an app is a browser game.
     * This parameter is valid only for RPK games and when compatible devices include PCs (the values of appAdapters include 15).
     * 0: no
     * 1: yes
     */
    private int $webGameFlag = 0;

    /**
     * @var string $privacyRightsUrl (255) URL for users to add, delete, modify, and view their personal data.
     */
    private string $privacyRightsUrl = "https://";

    public function __construct() {}

    public function asArray() {
        return [
            'defaultLang'         => $this->defaultLang,
            'childType'           => $this->childType,
            'grandChildType'      => $this->grandChildType,
            'privacyPolicy'       => $this->privacyPolicy,
            'appAdapters'         => $this->appAdapters,
            'appNetType'          => $this->appNetType,
            'isFree'              => $this->isFree,
            'price'               => $this->price,
            'priceDetail'         => $this->priceDetail,
            'publishCountry'      => $this->publishCountry,
            'contentRate'         => $this->contentRate,
            'isAppForcedUpdate'   => $this->isAppForcedUpdate,
            'hispaceAutoDown'     => $this->hispaceAutoDown,
            'appTariffType'       => $this->appTariffType,
            'publicationNumber'   => $this->publicationNumber,
            'cultureRecordNumber' => $this->cultureRecordNumber,
            'developerNameCn'     => $this->developerNameCn,
            'developerNameEn'     => $this->developerNameEn,
            'developerWebsite'    => $this->developerWebsite,
            'familyShareTag'      => $this->familyShareTag,
            'deviceTypes'         => $this->deviceTypes,
            'webGameFlag'         => $this->webGameFlag,
            'privacyRightsUrl'    => $this->privacyRightsUrl
        ];
    }

    function asObject(): object {
        return (object) $this->asArray();
    }

    /** TODO: Implement validate() method. */
    function validate(): void {

    }
}
