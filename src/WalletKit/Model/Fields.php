<?php

namespace HMS\WalletKit\Model;

/**
 * Class HMS WalletKit Fields
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/fields-0000001050158368">Fields</a>
 * @author Martin Zeitler
 */
class Fields {

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
     * @var array<RelatedPassIds> $relatedPassIds ID of a linked pass, if any.
     * This object is only available for a loyalty card instance and is used to associate with a
     * coupon instance under the same user account. Do not set this object in the loyalty card model.
     */
    private array $relatedPassIds;

    /**
     * @var array<Location> $locationList Geographical location.
     * This parameter can be used if the pass supports geofence notifications.
     */
    private array $locationList;

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
    private array $commonFields;

    /**
     * @var array<ValueObject> $appendFields
     * List of additional displayable fields, which are defined by the issuer to distinguish the same type of passes in different scenarios.
     * For details about the fields used by each type of pass, please refer to:
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-Guides/access_membership-0000001050044329#section1811873155314">UI Design</a>
     */
    private array $appendFields;

    /**
     * @var array<ValueObject> $messageList
     * Notification for a pass, which is irrelevant with the common displayable fields of the pass.
     * It is used to notify users, for example, of using the pass in a given period of time.
     * The parameter label is mandatory.
     */
    private array $messageList;

    /**
     * @var array<ValueObject> $timeList List of time information.
     */
    private array $timeList;

    /**
     * @var array<ValueObject> $imageList
     * List of images that are displayed in a succession on the pass details page, for example,
     * hotel pictures and services that are displayed successively on the hotel loyalty card.
     */
    private array $imageList;

    /**
     * @var array<ValueObject> $ticketInfoList
     * Description of a ticket stub that you have defined.
     * This parameter is available only for transit passes.
     */
    private array $ticketInfoList;

    /**
     * @var array<ValueObject> $urlList Links to be shown on a pass. The label field is mandatory.
     */
    private array $urlList;

    /**
     * @var array<Localized> $localized Local language, which is defined here and referenced by other fields
     * through the corresponding key when the fields need to be displayed in the local language.
     */
    private array $localized;

    public function __construct( array $config ) {
        return $this->fromArray( $config );
    }

    private function fromArray( array $config ): Fields {
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
            $this->status = new Status($config['status']);
        }
        if (isset($config['relatedPassIds'])) {
            $this->relatedPassIds = $config['relatedPassIds'];
        }
        if (isset($config['locationList'])) {
            $this->locationList = [
                new Location( $config['locationList'] )
            ];
        }
        if (isset($config['barCode'])) {
            $this->barCode = new BarCode($config['barCode']);
        }
        if (isset($config['commonFields'])) {
            $this->commonFields = $config['commonFields'];
        }
        if (isset($config['appendFields'])) {
            $this->appendFields = $config['appendFields'];
        }
        if (isset($config['messageList'])) {
            $this->messageList = $config['messageList'];
        }
        if (isset($config['timeList'])) {
            $this->timeList = $config['timeList'];
        }
        if (isset($config['imageList'])) {
            $this->imageList = $config['imageList'];
        }
        if (isset($config['ticketInfoList'])) {
            $this->ticketInfoList = $config['ticketInfoList'];
        }
        if (isset($config['urlList'])) {
            $this->urlList = $config['urlList'];
        }
        if (isset($config['localized'])) {
            $this->localized = $config['localized'];
        }
        return $this;
    }

    public function toObject(): object {
        return (object) [
            'countryCode'    => $this->countryCode,
            'currencyCode'   => $this->currencyCode,
            'allowMultiUser' => $this->allowMultiUser,
            'status'         => $this->status->toObject(),
            'relatedPassIds' => $this->relatedPassIds,
            'locationList'   => $this->locationList,
            'barCode'        => $this->barCode,
            'commonFields'   => $this->commonFields,
            'appendFields'   => $this->appendFields,
            'messageList'    => $this->messageList,
            'timeList'       => $this->timeList,
            'imageList'      => $this->imageList,
            'ticketInfoList' => $this->ticketInfoList,
            'urlList'        => $this->urlList,
            'localized'      => $this->localized
        ];
    }
}