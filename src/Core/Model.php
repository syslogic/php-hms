<?php
namespace HMS\Core;

/**
* Class HMS Core Model
*
* @author Martin Zeitler
*/
abstract class Model {
    protected array $mandatory_fields = [];
    protected array $optional_fields  = [];
    abstract function asObject(): object;
    abstract function validate(): bool;
}
