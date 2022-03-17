<?php


namespace Modules\Core\Entities\BaseTypes;


use Modules\Core\Interfaces\ObjectInterface;

class StringType extends BaseType
{
    public function __construct(string $value)
    {
        parent::__construct($value);
    }

    public function length(): int
    {
        return mb_strlen($this->value());
    }
}
