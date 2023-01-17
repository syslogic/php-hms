<?php /** @noinspection PhpUnused */
namespace HMS\DriveKit;

/**
 * Class HMS DriveKit Constants
 *
 * @author Martin Zeitler
 */
class Constants {
    public const DRIVE_KIT_BASE_URL = "https://driveapis.cloud.huawei.com.cn";
    public const DRIVE_KIT_ABOUT_URL = self::DRIVE_KIT_BASE_URL . "/drive/v1/about?fields=";
    public const DRIVE_KIT_FILES_URL = self::DRIVE_KIT_BASE_URL . "/drive/v1/files/";
    public const DRIVE_KIT_THUMBNAILS_URL = self::DRIVE_KIT_BASE_URL . "/drive/v1/thumbnails/{fileId}?form=content";
    public const DRIVE_KIT_SMALL_THUMBNAILS_URL = self::DRIVE_KIT_BASE_URL . "drive/v1/smallThumbnails/{fileId}?form=content";
    public const DRIVE_KIT_CHANGES_URL = self::DRIVE_KIT_BASE_URL . "/drive/v1/changes";
    public const DRIVE_KIT_CHANNELS_URL = self::DRIVE_KIT_BASE_URL . "/drive/v1/channels/stop";
    public const DRIVE_KIT_COMMENTS_URL = self::DRIVE_KIT_BASE_URL . "/drive/v1/files/{fileId}/comments";
    public const DRIVE_KIT_REPLIES_URL = self::DRIVE_KIT_BASE_URL . "/drive/v1/files/{fileId}/comments/{commentId}/replies";
    public const DRIVE_KIT_HISTORY_VERSIONS_URL = self::DRIVE_KIT_BASE_URL . "/drive/v1/files/{fileId}/historyVersions";
    public const DRIVE_KIT_BATCH_URL = self::DRIVE_KIT_BASE_URL . "/batch/drive/v3";
}
