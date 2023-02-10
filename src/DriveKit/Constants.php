<?php /** @noinspection PhpUnused */
namespace HMS\DriveKit;

/**
 * Class HMS DriveKit Constants
 *
 * @author Martin Zeitler
 */
class Constants {
    public const DRIVE_KIT_SCOPES = [

        // Permission to allow access to only the files created or opened by the app.
        'https://www.huawei.com/auth/drive.file',

        // Permissions to upload and store app data.
        'https://www.huawei.com/auth/drive.appdata',

        // Permission to access all files except those in the app data folder of a user.
        'https://www.huawei.com/auth/drive',

        // Read-only permission on file metadata and content.
        'https://www.huawei.com/auth/drive.readonly',

        // Read and write permission on file metadata, not allowing file content reading, writing, download, or upload, and not supporting file creation or deletion.
        'https://www.huawei.com/auth/drive.metadata',

        // Read-only permission on file metadata, not allowing file content reading or download.
        'https://www.huawei.com/auth/drive.metadata.readonly'
    ];
    public const DRIVE_KIT_BASE_URL = "https://driveapis.cloud.huawei.com.cn";
    public const DRIVE_KIT_ABOUT_URL = self::DRIVE_KIT_BASE_URL . "/drive/v1/about?fields=";
    public const DRIVE_KIT_FILES_URL = self::DRIVE_KIT_BASE_URL . "/drive/v1/files";
    public const DRIVE_KIT_THUMBNAILS_URL = self::DRIVE_KIT_BASE_URL . "/drive/v1/thumbnails/{fileId}?form=content";
    public const DRIVE_KIT_SMALL_THUMBNAILS_URL = self::DRIVE_KIT_BASE_URL . "drive/v1/smallThumbnails/{fileId}?form=content";
    public const DRIVE_KIT_CHANGES_URL = self::DRIVE_KIT_BASE_URL . "/drive/v1/changes";
    public const DRIVE_KIT_CHANNELS_URL = self::DRIVE_KIT_BASE_URL . "/drive/v1/channels/stop";
    public const DRIVE_KIT_COMMENTS_URL = self::DRIVE_KIT_BASE_URL . "/drive/v1/files/{fileId}/comments";
    public const DRIVE_KIT_REPLIES_URL = self::DRIVE_KIT_BASE_URL . "/drive/v1/files/{fileId}/comments/{commentId}/replies";
    public const DRIVE_KIT_HISTORY_VERSIONS_URL = self::DRIVE_KIT_BASE_URL . "/drive/v1/files/{fileId}/historyVersions";
    public const DRIVE_KIT_BATCH_URL = self::DRIVE_KIT_BASE_URL . "/batch/drive/v3";
}
