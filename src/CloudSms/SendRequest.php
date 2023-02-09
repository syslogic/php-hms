<?php
namespace HMS\CloudSms;

use HMS\Core\Model;
use InvalidArgumentException;

/**
 * Class HMS SmsService SendRequest
 * @author Martin Zeitler
 * @deprecated
 */
class SendRequest extends Model {

    protected array $mandatory_fields = ['account', 'password', 'requestLists'];
    protected array $optional_fields  = ['requestId', 'statusCallback'];

    /**
     * @var string|null $account (mandatory)
     */
    protected string|null $account = null;

    /**
     * @var string|null $password
     */
    protected string|null $password = null;

    /**
     * @var array $requestLists
     */
    protected array $requestLists = [];

    /**
     * @var string|null $requestId
     */
    protected string|null $requestId = null;

    /**
     * @var string|null $statusCallback
     */
    protected string|null $statusCallback = null;

    public function __construct( array|null $model = null ) {
        if ( is_array( $model )) {$this->parse_array( $model );}
    }

    private function parse_array( array $data ): void {
        foreach ($data as $key => $value) {
            if ( in_array($key, array_merge($this->mandatory_fields, $this->optional_fields)) ) {
                $this->$key = $value;
            }
        }
    }

    static function fromArray(array $model): Model {
        return new SendRequest( $model );
    }

    public function asObject(): object {
        return (object) [
            'account'        => $this->account,
            'password'       => $this->password,
            'requestLists'   => $this->requestLists,
            'requestId'      => $this->requestId,
            'statusCallback' => $this->statusCallback
        ];
    }

    function validate(): bool {
        if (empty($this->account) || strlen($this->account) > 30) {
            throw new InvalidArgumentException('account must not be null or longer than 30 chars');
        }
        if (empty($this->password) || strlen($this->password) > 100) {
            throw new InvalidArgumentException('password must not be null or longer than 100 chars');
        }
        if (sizeof($this->requestLists) == 0 || sizeof($this->requestLists) > 20) {
            throw new InvalidArgumentException('requestLists must be an array of 1-20 items');
        }
        if ($this->requestId != null && strlen($this->requestId) > 20) {
            throw new InvalidArgumentException('requestId must not be longer than 20 chars');
        }
        if ($this->statusCallback != null && strlen($this->statusCallback) > 1024) {
            throw new InvalidArgumentException('statusCallback must not be longer than 1024 chars');
        }
        return true;
    }
}
