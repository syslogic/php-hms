<?php
namespace HMS\DriveKit;

use HMS\DriveKit\About\About;
use HMS\DriveKit\Batch\BatchCallback;
use HMS\DriveKit\Changes\Changes;
use HMS\DriveKit\Channels\Channels;
use HMS\DriveKit\Comments\Comments;
use HMS\DriveKit\Files\Files;
use HMS\DriveKit\HistoryVersions\HistoryVersions;
use HMS\DriveKit\Replies\Replies;
use HMS\DriveKit\SmallThumbnail\SmallThumbnail;
use HMS\DriveKit\Thumbnail\Thumbnail;

/**
 * Interface HMS DriveKit
 * @author Martin Zeitler
 */
interface IDriveKit {
    public function getAbout(): About;
    public function getBatchCallback(): BatchCallback;
    public function getChanges(): Changes;
    public function getChannels(): Channels;
    public function getComments(): Comments;
    public function getFiles(): Files;
    public function getHistoryVersions(): HistoryVersions;
    public function getReplies(): Replies;
    public function getThumbnail(): Thumbnail;
    public function getSmallThumbnail(): SmallThumbnail;
}
