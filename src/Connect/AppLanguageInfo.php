<?php
namespace HMS\Connect;

use HMS\Core\Model;

/**
 * Class HMS Connect AppLanguageInfo
 *
 * @see https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-language-info-update-0000001158245057#section13576204051611
 * @author Martin Zeitler
 */
class AppLanguageInfo extends Model {

    protected array $mandatory_fields = [];
    protected array $optional_fields  = [];

    /**
     * @var string $lang (64) Language. For details, please refer to Languages.
     */
    private string $lang = "en-US";

    /**
     * @var string $appName (64) App name in a language. This parameter is mandatory when a language type is added.
     */
    private string $appName = "";

    /**
     * @var string $appDesc (8000) Full introduction in a language.
     */
    private string $appDesc = "";

    /**
     * @var string $briefInfo (80) Brief introduction in a language.
     */
    private string $briefInfo = "";

    /**
     * @var string $newFeatures (500) New features in a language.
     */
    private string $newFeatures = "";

    public function __construct() {}

    public function asArray(): array {
        return [
                   'lang' => $this->lang,
                'appName' => $this->appName,
                'appDesc' => $this->appDesc,
              'briefInfo' => $this->briefInfo,
            'newFeatures' => $this->newFeatures
        ];
    }

    function asObject(): object {
        return (object) $this->asArray();
    }

    /** TODO: Implement validate() method. */
    function validate(): void {

    }
}
