<?php
namespace HMS\PushKit\Android;

use HMS\Core\Model;
use InvalidArgumentException;

/**
 * Class HMS PushKit AndroidNotification
 *
 * @author Martin Zeitler
 */
class AndroidNotification extends Model {

    protected array $mandatory_fields = ['title', 'body', 'click_action'];
    protected array $optional_fields  = [
        'icon', 'color', 'sound', 'default_sound', 'tag', 'body_loc_key', 'body_loc_args', 'title_loc_key', 'title_loc_args',
        'multi_lang_key', 'channel_id', 'notify_summary', 'image', 'style', 'big_title', 'big_body', 'auto_clear', 'notify_id',
        'group', 'badge', 'ticker', 'when', 'importance', 'use_default_vibrate', 'use_default_light', 'vibrate_config',
        'visibility', 'light_settings', 'foreground_show', 'profile_id', 'inbox_content', 'buttons'
    ];

    protected const INVALID_NOTIFICATION_TITLE = 'title is mandatory';
    protected const INVALID_NOTIFICATION_BODY  = 'body is mandatory';
    protected const INVALID_CLICK_ACTION       = 'click_action is mandatory';

    /**
     * @var string $title
     */
    protected string|null $title = null;

    /**
     * @var string $body
     */
    protected string|null $body = null;

    /**
     * @var string|null $image
     */
    protected string|null $image = null;

    /**
     * @var string $icon
     */
    private $icon = null;

    /**
     * @var string $color
     */
    private $color = null;

    /**
     * @var string $sound
     */
    private $sound = null;


    /**
     * @var bool $default_sound
     */
    private bool $default_sound = true;

    /**
     * @var string $tag
     */
    private $tag = null;

    /**
     * @var string $click_action
     */
    private $click_action = null;

    /**
     * @var string $body_loc_key
     */
    private $body_loc_key = null;

    /**
     * @var string $body_loc_args
     */
    private $body_loc_args = null;

    /**
     * @var string $title_loc_key
     */
    private $title_loc_key = null;

    /**
     * @var string $title_loc_args
     */
    private $title_loc_args = null;

    /**
     * @var string $channel_id
     */
    private $channel_id = null;

    /**
     * @var string $notify_summary
     */
    private $notify_summary = null;

    /**
     * @var string $notify_icon
     */
    private $notify_icon = null;

    /**
     * @var int $style Notification style
     * 0：default
     * 1：big text
     * 2：big photo
     */
    private $style = 0;

    /**
     * @var string $big_title
     */
    private $big_title = null;

    /**
     * @var string $big_body
     */
    private $big_body = null;

    /**
     * @var string $auto_clear
     */
    private $auto_clear = null;

    /**
     * @var string $notify_id
     */
    private $notify_id = null;

    /**
     * @var string $group
     */
    private $group = null;

    /**
     * @var string $badge
     */
    private $badge = null;

    /**
     * @var string $ticker
     */
    private $ticker = null;

    /**
     * @var string $auto_cancel
     */
    private $auto_cancel = null;

    /**
     * @var string $when
     */
    private $when = null;

    /**
     * @var string $importance
     */
    private $importance = 'NORMAL';

    /**
     * @var string $use_default_vibrate
     */
    private $use_default_vibrate = null;

    /**
     * @var string $use_default_light
     */
    private $use_default_light = null;

    /**
     * @var string $vibrate_config
     */
    private $vibrate_config = null;

    /**
     * @var string $visibility
     */
    private $visibility = null;

    /**
     * @var string $light_settings
     */
    private $light_settings = null;

    /**
     * @var string $foreground_show
     */
    private $foreground_show = null;

    public function __construct( array $data ) {
        $this->parse_array( $data );
    }

    /** Conditionally adding array items. */
    public function asArray(): array {
        $data = [];
        if ($this->title               != null) {$data['title']               = $this->title;}
        if ($this->body                != null) {$data['body']                = $this->body;}
        if ($this->image               != null) {$data['image']               = $this->image;}
        if ($this->click_action        != null) {$data['click_action']        = $this->click_action;}
        if ($this->icon                != null) {$data['icon']                = $this->icon;}
        if ($this->color               != null) {$data['color']               = $this->color;}
        if ($this->sound               != null) {$data['sound']               = $this->sound;}
        if ($this->tag                 != null) {$data['tag']                 = $this->tag;}
        if ($this->body_loc_key        != null) {$data['body_loc_key']        = $this->body_loc_key;}
        if ($this->body_loc_args       != null) {$data['body_loc_args']       = $this->body_loc_args;}
        if ($this->title_loc_key       != null) {$data['title_loc_key']       = $this->title_loc_key;}
        if ($this->title_loc_args      != null) {$data['title_loc_args']      = $this->title_loc_args;}
        if ($this->channel_id          != null) {$data['channel_id']          = $this->channel_id;}
        if ($this->notify_summary      != null) {$data['notify_summary']      = $this->notify_summary;}
        if ($this->notify_icon         != null) {$data['notify_icon']         = $this->notify_icon;}
        if ($this->style               != null) {$data['style']               = $this->style;}
        if ($this->big_title           != null) {$data['big_title']           = $this->big_title;}
        if ($this->big_body            != null) {$data['big_body']            = $this->big_body;}
        if ($this->auto_clear          != null) {$data['auto_clear']          = $this->auto_clear;}
        if ($this->notify_id           != null) {$data['notify_id']           = $this->notify_id;}
        if ($this->group               != null) {$data['group']               = $this->group;}
        if ($this->badge               != null) {$data['badge']               = $this->badge;}
        if ($this->ticker              != null) {$data['ticker']              = $this->ticker;}
        if ($this->auto_cancel         != null) {$data['auto_cancel']         = $this->auto_cancel;}
        if ($this->when                != null) {$data['when']                = $this->when;}
        if ($this->importance          != null) {$data['importance']          = $this->importance;}
        if ($this->use_default_vibrate != null) {$data['use_default_vibrate'] = $this->use_default_vibrate;}
        if ($this->use_default_light   != null) {$data['use_default_light']   = $this->use_default_light;}
        if ($this->vibrate_config      != null) {$data['vibrate_config']      = $this->vibrate_config;}
        if ($this->visibility          != null) {$data['visibility']          = $this->visibility;}
        if ($this->light_settings      != null) {$data['light_settings']      = $this->light_settings;}
        if ($this->foreground_show     != null) {$data['foreground_show']     = $this->foreground_show;}
        return $data;
    }

    private function parse_array( array $data ): void {
        foreach ($data as $key => $value) {
            if ( in_array($key, array_merge($this->mandatory_fields, $this->optional_fields)) ) {
                $this->$key = $value;
            }
        }
    }

    public function asObject(): object {
        return (object) $this->asArray();
    }

    static function fromArray( array $model ): AndroidNotification {
        return new AndroidNotification( $model );
    }

    /** TODO: Implement validate() method. */
    function validate(): bool {
        if ( $this->title        == null ) {throw new InvalidArgumentException(self::INVALID_NOTIFICATION_TITLE);}
        if ( $this->body         == null ) {throw new InvalidArgumentException(self::INVALID_NOTIFICATION_BODY);}
        if ( $this->click_action == null ) {throw new InvalidArgumentException(self::INVALID_CLICK_ACTION);}
        return true;
    }
}
