<?php
namespace HMS\WalletKit\Model;

/**
 * Class HMS WalletKit Status
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/status-0000001050160323">Status</a>
 * @author Martin Zeitler
 */
class Status {

    /** @var string|null $state Status of the pass. Values: active, inactive, completed, and expired. */
    private ?string $state;

    /** @var string|null $effectTime UTC time when the pass takes effect. */
    private ?string $effectTime;

    /** @var string|null $expireTime UTC time when the pass expires. The pass will automatically expire if the set expiration time is earlier than the current time. */
    private ?string $expireTime;

    public function __construct( array $config ) {
        if (! isset($config['state']) || ! in_array($config['state'], ['active', 'inactive', 'completed', 'expired'])) {
            throw new \InvalidArgumentException('Status requires at least a "state".');
        }
        if (isset($config['effectTime'])) {$this->effectTime = $config['effectTime'];}
        if (isset($config['expireTime'])) {$this->value = $config['expireTime'];}
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