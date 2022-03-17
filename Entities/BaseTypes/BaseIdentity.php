<?php

namespace Modules\Core\Entities\BaseTypes;

use Modules\Core\Entities\AbstractIdentity;
use Modules\Core\Interfaces\ObjectInterface;

abstract class BaseIdentity extends AbstractIdentity
{
    public function __construct(BaseType $value, array $attributes = [])
    {
        $this->initAttributes(array_merge($attributes, [
            'value' => $value
        ]));
    }

    public function value(): BaseType
    {
        return $this->attribute('value');
    }

    public function equals(ObjectInterface $object): bool
    {
        return (
            ($object instanceof static) && $this->value()->equals($object->value())
        );
    }

    public function __toString(): string
    {
        return $this->value()->__toString();
    }
}