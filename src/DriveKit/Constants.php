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
    public const DRIVE_KIT_MIME_TYPE_FOLDER = 'application/vnd.huawei-apps.folder';
    public const DRIVE_KIT_MIME_TYPES = [
        '3gp' => 'video/3gpp',
        'apk' => 'application/vnd.android.package-archive',
        'asf' => 'video/x-ms-asf',
        'avi' => 'video/x-msvideo',
        'bin' => 'application/octet-stream',
        'bmp' => 'image/bmp',
        'c' => 'text/plain',
        'class' => 'application/octet-stream',
        'conf' => 'text/plain',
        'cpp' => 'text/plain',
        'doc' => 'application/msword',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'xls' => 'application/vnd.ms-excel',
        'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'exe' => 'application/octet-stream',
        'gif' => 'image/gif',
        'gtar' => 'application/x-gtar',
        'gz' => 'application/x-gzip',
        'h' => 'text/plain',
        'htm' => 'text/html',
        'html' => 'text/html',
        'jar' => 'application/java-archive',
        'java' => 'text/plain',
        'jpeg' => 'image/jpeg',
        'jpg' => 'image/jpeg',
        'jpe' => 'image/jpeg',
        'js' => 'application/x-javascript',
        'log' => 'text/plain',
        'm3u' => 'audio/x-mpegurl',
        'm4a' => 'audio/mp4a-latm',
        'm4b' => 'audio/mp4a-latm',
        'm4p' => 'audio/mp4a-latm',
        'm4u' => 'video/vnd.mpegurl',
        'm4v' => 'video/x-m4v',
        'mov' => 'video/quicktime',
        'mp2' => 'audio/x-mpeg',
        'mp3' => 'audio/x-mpeg',
        'mp4' => 'video/mp4',
        'mpc' => 'application/vnd.mpohun.certificate',
        'mpeg' => 'video/mpeg',
        'mpe' => 'video/mpeg',
        'mpg' => 'video/mpeg',
        'mpg4' => 'video/mp4',
        'mpga' => 'audio/mpeg',
        'msg' => 'application/vnd.ms-outlook',
        'ogg' => 'audio/ogg',
        'pdf' => 'application/pdf',
        'png' => 'image/png',
        'pps' => 'application/vnd.ms-powerpoint',
        'ppt' => 'application/vnd.ms-powerpoint',
        'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        'prop' => 'text/plain',
        'rc' => 'text/plain',
        'rmvb' => 'audio/x-pn-realaudio',
        'rtf' => 'application/rtf',
        'sh' => 'text/plain',
        'tar' => 'application/x-tar',
        'tgz' => 'application/x-compressed',
        'txt' => 'text/plain',
        'wav' => 'audio/x-wav',
        'wma' => 'audio/x-ms-wma',
        'wmv' => 'video/x-ms-wmv',
        'wps' => 'application/vnd.ms-works',
        'xml' => 'text/plain',
        'z' => 'application/x-compress',
        'zip' => 'application/x-zip-compressed',
        'wbmp' => 'image/vnd.wap.wbmp',
        'webp' => 'image/webp',
        'raw' => 'image/x-panasonic-raw',
        'dng' => 'image/x-adobe-dng',
        'arw' => 'image/x-sony-arw',
        'tif' => 'image/tiff',
        'ico' => 'image/x-icon',
        'mpo' => 'image/mpo',
        'mkv' => 'video/x-matroska',
        'webm' => 'video/x-matrosk',
        'm2ts' => 'video/mpeg',
        '3g2' => 'video/3gpp2',
        'rm' => 'video/x-pn-realvideo',
        'rv' => 'video/x-pn-realvideo',
        'ts' => 'video/mp2ts',
        'flv' => 'video/x-flv',
        'k3g' => 'video/k3g'
    ];

    public const DRIVE_KIT_BASE_URL = "https://driveapis.cloud.huawei.com.cn";
    public const DRIVE_KIT_ABOUT_URL = self::DRIVE_KIT_BASE_URL . "/drive/v1/about?fields=";
    public const DRIVE_KIT_FILES_URL = self::DRIVE_KIT_BASE_URL . "/drive/v1/files";
    public const DRIVE_KIT_FILES_UPLOAD_URL = self::DRIVE_KIT_BASE_URL . "/upload/drive/v1/files";
    public const DRIVE_KIT_THUMBNAILS_URL = self::DRIVE_KIT_BASE_URL . "/drive/v1/thumbnails/{fileId}?form=content";
    public const DRIVE_KIT_SMALL_THUMBNAILS_URL = self::DRIVE_KIT_BASE_URL . "drive/v1/smallThumbnails/{fileId}?form=content";
    public const DRIVE_KIT_CHANGES_URL = self::DRIVE_KIT_BASE_URL . "/drive/v1/changes";
    public const DRIVE_KIT_CHANGES_SUBSCRIBE_URL = self::DRIVE_KIT_BASE_URL . "/drive/v1/changes/subscirbe"; // typo ...
    public const DRIVE_KIT_CHANNELS_URL = self::DRIVE_KIT_BASE_URL . "/drive/v1/channels/stop";
    public const DRIVE_KIT_COMMENTS_URL = self::DRIVE_KIT_BASE_URL . "/drive/v1/files/{fileId}/comments";
    public const DRIVE_KIT_REPLIES_URL = self::DRIVE_KIT_BASE_URL . "/drive/v1/files/{fileId}/comments/{commentId}/replies";
    public const DRIVE_KIT_HISTORY_VERSIONS_URL = self::DRIVE_KIT_BASE_URL . "/drive/v1/files/{fileId}/historyVersions";
    public const DRIVE_KIT_HISTORY_VERSION_URL = self::DRIVE_KIT_BASE_URL . "/drive/v1/files/{fileId}/historyVersions/{historyVersionId}";
    public const DRIVE_KIT_BATCH_URL = self::DRIVE_KIT_BASE_URL . "/batch/drive/v3";
}
