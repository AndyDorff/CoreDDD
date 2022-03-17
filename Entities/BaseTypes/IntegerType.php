<?php


namespace Modules\Core\Entities\BaseTypes;


class IntegerType extends NumericType
{
    public function __construct(int $value)
    {
        parent::__construct($value);
    }
}
