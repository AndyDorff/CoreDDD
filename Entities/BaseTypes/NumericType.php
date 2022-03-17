<?php


namespace Modules\Core\Entities\BaseTypes;


class NumericType extends BaseType
{
    protected function doValidate($value): bool
    {
        return
            is_numeric($value) &&
            parent::doValidate($value);
    }
}
