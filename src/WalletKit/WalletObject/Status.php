<?php
namespace HMS\WalletKit\WalletObject;

/**
 * Class HMS WalletKit Status
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/status-0000001050160323">Status</a>
 * @author Martin Zeitler
 */
class Status {

    /** @const STATES Values: active, inactive, completed, and expired. */
    private const STATES = ['active', 'inactive', 'completed', 'expired'];

    /** @var string|null $state Status of the pass. */
    private ?string $state;

    /** @var string|null $effectTime UTC time when the pass takes effect. */
    private ?string $effectTime;

    /**
     * @var string|null $expireTime UTC time when the pass expires.
     * The pass will automatically expire if the set expiration time is earlier than the current time.
     */
    private ?string $expireTime;

    public function __construct( array $config ) {
        if (! in_array($config['state'], self::STATES)) {
            throw new \InvalidArgumentException('Status requires at least a "state".');
        }
        $this->state = $config['state'];
        if (isset($config['effectTime'])) {$this->effectTime = $config['effectTime'];}
        if (isset($config['expireTime'])) {$this->expireTime = $config['expireTime'];}
        return $this;
    }

    public static function fromArray(array $model ): Status {
        return new Status( $model );
    }

    public function asObject(): object {
        return (object) [
            'state' => $this->state,
            'effectTime' => $this->effectTime,
            'expireTime' => $this->expireTime
        ];
    }

    function validate(): bool {
        return true;
    }
}