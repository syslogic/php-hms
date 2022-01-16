<?php
namespace HMS\PushKit\QuickApp;

use HMS\Core\Model;
use JetBrains\PhpStorm\Pure;

/**
 * Class HMS PushKit QuickAppNotification
 *
 * @author Martin Zeitler
 */
class QuickAppNotification extends Model {

    protected array $mandatory_fields = ['title', 'body'];
    protected array $optional_fields  = ['image'];

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

    #[Pure]
    public function __construct() {
        //parent::__construct();
    }

    public function asObject(): object {
        return (object) [
            'title' => $this->title,
            'body'  => $this->body,
            'image' => $this->image
        ];
    }

    /** TODO: Implement fromArray() method. */
    static function fromArray( array $model ): QuickAppNotification {
        return new QuickAppNotification( $model );
    }

    /** TODO: Implement validate() method. */
    function validate(): bool {
        return true;
    }
}
