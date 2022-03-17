<?php


namespace Modules\Core\Exceptions;


use Modules\Core\Entities\BaseTypes\BaseType;

class InvalidTypeValueException extends CoreException
{
    /**
     * @var BaseType
     */
    private $type;
    private $value;

    public function setType(BaseType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function setValue($value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getType(): BaseType
    {
        return $this->type;
    }

    public function getValue()
    {
        return $this->value;
    }
}
