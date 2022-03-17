<?php

namespace Modules\Core\Entities\BaseTypes;

class NullType extends BaseType
{
    public function __construct()
    {
        parent::__construct(null);
    }
}