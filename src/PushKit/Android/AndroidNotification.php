<?php

namespace HMS\PushKit\Android;

use HMS\PushKit\Notification;
use JetBrains\PhpStorm\Pure;

/**
 * Class HMS PushKit AndroidNotification
 *
 * @author Martin Zeitler
 */
class AndroidNotification extends Notification {

    protected array $mandatory_fields = ['title', 'body'];
    protected array $optional_fields  = ['image'];

    /**
     * @var string $icon
     */
    private $icon;

    /**
     * @var string $color
     */
    private $color;

    /**
     * @var string $sound
     */
    private $sound;

    /**
     * @var string $tag
     */
    private $tag;

    /**
     * @var string $click_action
     */
    private $click_action;

    /**
     * @var string $body_loc_key
     */
    private $body_loc_key;

    /**
     * @var string $body_loc_args
     */
    private $body_loc_args;

    /**
     * @var string $title_loc_key
     */
    private $title_loc_key;

    /**
     * @var string $title_loc_args
     */
    private $title_loc_args;

    /**
     * @var string $channel_id
     */
    private $channel_id;

    /**
     * @var string $notify_summary
     */
    private $notify_summary;

    /**
     * @var string $notify_icon
     */
    private $notify_icon;

    /**
     * @var int $style Notification style
     * 0：default
     * 1：big text
     * 2：big photo
     */
    private $style;

    /**
     * @var string $big_title
     */
    private $big_title;

    /**
     * @var string $big_body
     */
    private $big_body;

    /**
     * @var string $auto_clear
     */
    private $auto_clear;

    /**
     * @var string $notify_id
     */
    private $notify_id;

    /**
     * @var string $group
     */
    private $group;

    /**
     * @var string $badge
     */
    private $badge;

    /**
     * @var string $ticker
     */
    private $ticker;

    /**
     * @var string $auto_cancel
     */
    private $auto_cancel;

    /**
     * @var string $when
     */
    private $when;

    /**
     * @var string $importance
     */
    private $importance;

    /**
     * @var string $use_default_vibrate
     */
    private $use_default_vibrate;

    /**
     * @var string $use_default_light
     */
    private $use_default_light;

    /**
     * @var string $vibrate_config
     */
    private $vibrate_config;

    /**
     * @var string $visibility
     */
    private $visibility;

    /**
     * @var string $light_settings
     */
    private $light_settings;

    /**
     * @var string $foreground_show
     */
    private $foreground_show;

    #[Pure] public function __construct(string $title, string $body, string|null $image=null ) {
        parent::__construct( $title, $body, $image );
    }

    public function asObject(): object {
        return (object) [
            'title' => $this->title,
            'body' => $this->body,
            'image' => $this->image
        ];
    }
}
