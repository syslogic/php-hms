<?php /** @noinspection PhpUnused */
namespace HMS\WalletKit;

/**
 * Class HMS WalletKit Constants
 *
 * @author Martin Zeitler
 */
class Constants {

    /** Wallet Server: Chinese mainland. */
    public const WALLET_SERVER_CN = "https://wallet-passentrust-drcn.cloud.huawei.com.cn";

    /** Wallet Server: Asia. */
    public const WALLET_SERVER_ASIA = "https://wallet-passentrust-dra.cloud.huawei.asia";

    /** Wallet Server: Europe. */
    public const WALLET_SERVER_EU = "https://wallet-passentrust-dre.cloud.huawei.eu";

    /** Wallet Server: Latin America. */
    public const WALLET_SERVER_LAT = "https://wallet-passentrust-dra.cloud.huawei.lat";

    /** Wallet Server: Russia. */
    public const WALLET_SERVER_RU = "https://wallet-passentrust-drru.cloud.huawei.ru";

    /** Wallet Gateway Server: Chinese mainland. */
    public const WALLET_GATEWAY_SERVER_CN = "https://wallet-gateway-drcn.cloud.huawei.com.cn";

    /** Wallet Gateway Server: Asia. */
    public const WALLET_GATEWAY_SERVER_ASIA = "https://wallet-gateway-dra.cloud.huawei.asia";

    /** Wallet Gateway Server: Europe. */
    public const WALLET_GATEWAY_SERVER_EU = "https://wallet-gateway-dre.cloud.huawei.eu";

    /** Wallet Gateway Server: Latin America. */
    public const WALLET_GATEWAY_SERVER_LAT = "https://wallet-gateway-dra.cloud.huawei.lat";

    /** Wallet Gateway Server: Russia. */
    public const WALLET_GATEWAY_SERVER_RU = "https://wallet-gateway-drru.cloud.huawei.ru";

    public const WALLET_EVENT_TICKET_MODEL = "/hmspass/v1/eventticket/model";
    public const WALLET_BOARDING_PASS_MODEL = "/hmspass/v1/flight/model";
    public const WALLET_GIFT_CARD_MODEL = "/hmspass/v1/giftcard/model";
    public const WALLET_LOYALTY_CARD_MODEL = "/hmspass/v1/loyalty/model";
    public const WALLET_OFFER_MODEL = "/hmspass/v1/offer/model";
    public const WALLET_TRANSIT_PASS_MODEL = "/hmspass/v1/transit/model";
}
