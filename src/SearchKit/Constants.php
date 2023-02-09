<?php /** @noinspection PhpUnused */
namespace HMS\SearchKit;

/**
 * Class HMS SearchKit Constants
 *
 * @author Martin Zeitler
 */
class Constants {

    /** Europe. */
    public const SEARCH_KIT_BASE_URL_EU = "https://search-dre.cloud.huawei.com";

    /** Asia, Africa and Latin America. */
    public const SEARCH_KIT_BASE_URL = "https://search-dra.cloud.huawei.com";

    public const SEARCH_KIT_WEB_SEARCH_URL = "/apis/search/v1.0.0/web/search";
    public const SEARCH_KIT_IMAGE_SEARCH_URL = "/apis/search/v1.0.0/image/search";
    public const SEARCH_KIT_VIDEO_SEARCH_URL = "/apis/search/v1.0.0/video/search";
    public const SEARCH_KIT_NEWS_SEARCH_URL = "/apis/search/v1.0.0/news/search";
}
