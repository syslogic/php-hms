<?php

namespace HMS\WalletKit\WalletObject;

use HMS\Core\Model;

/**
 * Class HMS WalletKit Fields
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/fields-0000001050158368">Fields</a>
 * @author Martin Zeitler
 */
class Fields extends Model {

    /** @var string $countryCode Country/Region code. */
    private string $countryCode;

    /** @var string $currencyCode Currency unit. */
    private string $currencyCode;

    /**
     * @var bool $allowMultiUser Whether a pass can be claimed by multiple users. The options are true
     * and false. If this field does not exist or is set to false, a pass can be claimed by one user only.
     */
    private bool $allowMultiUser = false;

    /**
     * @var Status $status Status information that you have defined,
     * including the status of a pass and the time when the pass expires.
     */
    private Status $status;

    /**
     * @var array<RelatedPassId> $relatedPassIds ID of a linked pass, if any.
     * This object is only available for a loyalty card instance and is used to associate with a
     * coupon instance under the same user account. Do not set this object in the loyalty card model.
     */
    private array $relatedPassIds = [];

    /**
     * @var array<Location> $locationList Geographical location.
     * This parameter can be used if the pass supports geofence notifications.
     */
    private array $locationList = [];

    /**
     * @var BarCode $barCode
     * Barcode or QR code, which is displayed when a pass is used.
     * Leave this parameter empty if the barcode or QR code need not be displayed.
     */
    private BarCode $barCode;

    /**
     * @var array<ValueObject> $commonFields
     * List of common displayable fields, namely, common attributes of a type of pass.
     * For details about the fields used by each type of pass, please refer to:
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-Guides/access_membership-0000001050044329#section1811873155314">UI Design</a>
     */
    private array $commonFields = [];

    /**
     * @var array<ValueObject> $appendFields
     * List of additional displayable fields, which are defined by the issuer to distinguish the same type of passes in different scenarios.
     * For details about the fields used by each type of pass, please refer to:
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-Guides/access_membership-0000001050044329#section1811873155314">UI Design</a>
     */
    private array $appendFields = [];

    /**
     * @var array<ValueObject> $messageList
     * Notification for a pass, which is irrelevant with the common displayable fields of the pass.
     * It is used to notify users, for example, of using the pass in a given period of time.
     * The parameter label is mandatory.
     */
    private array $messageList = [];

    /**
     * @var array<ValueObject> $timeList List of time information.
     */
    private array $timeList = [];

    /**
     * @var array<ValueObject> $imageList
     * List of images that are displayed in a succession on the pass details page, for example,
     * hotel pictures and services that are displayed successively on the hotel loyalty card.
     */
    private array $imageList = [];

    /**
     * @var array<ValueObject> $ticketInfoList
     * Description of a ticket stub that you have defined.
     * This parameter is available only for transit passes.
     */
    private array $ticketInfoList = [];

    /**
     * @var array<ValueObject> $urlList Links to be shown on a pass. The label field is mandatory.
     */
    private array $urlList = [];

    /**
     * @var array<Localized> $localized Local language, which is defined here and referenced by other fields
     * through the corresponding key when the fields need to be displayed in the local language.
     */
    private array $localized = [];

    public function __construct( array $config ) {
        if (isset($config['countryCode'])) {
            $this->countryCode = $config['countryCode'];
        }
        if (isset($config['currencyCode'])) {
            $this->currencyCode = $config['currencyCode'];
        }
        if (isset($config['allowMultiUser'])) {
            $this->allowMultiUser = $config['allowMultiUser'];
        }
        if (isset($config['status'])) {
            $this->status = new Status( $config['status'] );
        }
        if (isset($config['barCode'])) {
            $this->barCode = new BarCode($config['barCode']);
        }
        if (isset($config['relatedPassIds']) && is_array($config['relatedPassIds'])) {
            foreach ($config['relatedPassIds'] as $model) {
                $this->relatedPassIds[] = new RelatedPassId( $model );
            }
        }
        if (isset($config['locationList']) && is_array($config['locationList'])) {
            foreach ($config['locationList'] as $model) {
                $this->locationList[] = new Location( $model );
            }
        }
        if (isset($config['commonFields']) && is_array($config['commonFields'])) {
            foreach ($config['commonFields'] as $model) {
                $this->commonFields[] = new ValueObject( $model );
            }
        }
        if (isset($config['appendFields']) && is_array($config['appendFields'])) {
            foreach ($config['appendFields'] as $model) {
                $this->appendFields[] = new ValueObject( $model );
            }
        }
        if (isset($config['messageList']) && is_array($config['messageList'])) {
            foreach ($config['messageList'] as $model) {
                $this->messageList[] = new ValueObject( $model );
            }
        }
        if (isset($config['timeList']) && is_array($config['timeList'])) {
            foreach ($config['timeList'] as $model) {
                $this->timeList[] = new ValueObject( $model );
            }
        }
        if (isset($config['imageList']) && is_array($config['imageList'])) {
            foreach ($config['imageList'] as $model) {
                $this->imageList[] = new ValueObject( $model );
            }
        }
        if (isset($config['ticketInfoList']) && is_array($config['ticketInfoList'])) {
            foreach ($config['ticketInfoList'] as $model) {
                $this->ticketInfoList[] = new ValueObject( $model );
            }
        }
        if (isset($config['urlList']) && is_array($config['urlList'])) {
            foreach ($config['urlList'] as $model) {
                $this->urlList[] = new ValueObject( $model );
            }
        }
        if (isset($config['localized']) && is_array($config['localized'])) {
            foreach ($config['localized'] as $model) {
                $this->localized[] = new Localized( $model );
            }
        }
        return $this;
    }

    public static function fromArray(array $model ): Fields {
        return new Fields( $model );
    }

    public function asObject(): object {
        return (object) [
            'countryCode'    => $this->countryCode,
            'currencyCode'   => isset($this->currencyCode) ? $this->currencyCode : null,
            'allowMultiUser' => $this->allowMultiUser,
            'status'         => $this->status->asObject(),
            'barCode'        => $this->barCode->asObject(),
            'relatedPassIds' => $this->relatedPassIds, // array
            'locationList'   => $this->locationList,   // array
            'commonFields'   => $this->commonFields,   // array
            'appendFields'   => $this->appendFields,   // array
            'messageList'    => $this->messageList,    // array
            'timeList'       => $this->timeList,       // array
            'imageList'      => $this->imageList,      // array
            'ticketInfoList' => $this->ticketInfoList, // array
            'urlList'        => $this->urlList,        // array
            'localized'      => $this->localized       // array
        ];
    }

    function validate(): bool {
        return true;
    }
}