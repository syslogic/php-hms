<?php
namespace HMS\SmsService;

use HMS\Core\Model;
use InvalidArgumentException;

/**
 * Class HMS SmsService MtSmsMessage
 *
 * @author Martin Zeitler
 */
class MtSmsMessage extends Model {

    protected array $mandatory_fields = ['mobiles', 'templateId'];
    protected array $optional_fields  = ['templateParas', 'signature', 'messageId', 'extCode'];

    /**
     * @var array $mobiles (mandatory)
     */
    protected array $mobiles = [];

    /**
     * @var string|null $templateId (mandatory)
     */
    protected string|null $templateId = null;

    /**
     * @var object|null $templateParas
     */
    protected object|null $templateParas = null;

    /**
     * @var string|null $signature
     */
    protected string|null $signature = null;

    /**
     * @var string|null $messageId
     */
    protected string|null $messageId = null;

    /**
     * @var string|null $extCode
     */
    protected string|null $extCode = null;

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

    // TODO: Implement fromArray() method.
    static function fromArray(array $model): Model {
        return new SendRequest( $model );
    }

    public function asObject(): object {
        return (object) [
            'mobiles'       => $this->mobiles,
            'templateId'    => $this->templateId,
            'templateParas' => $this->templateParas,
            'signature'     => $this->signature,
            'messageId'     => $this->messageId,
            'extCode'       => $this->extCode
        ];
    }

    // TODO: Implement validate() method.
    function validate(): bool {
        if (!is_array($this->mobiles) || sizeof($this->mobiles) == 0 || sizeof($this->mobiles) > 100) {
            throw new InvalidArgumentException('mobiles must be an array of 1-100 items');
        }
        return true;
    }
}
