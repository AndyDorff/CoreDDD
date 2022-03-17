<?php


namespace Modules\Core\Entities\BaseTypes;


use Modules\Core\Entities\AbstractObject;
use Modules\Core\Exceptions\InvalidTypeValueException;
use Modules\Core\Interfaces\ObjectInterface;

abstract class BaseType extends AbstractObject
{
    private $value;

    /**
     * BaseType constructor.
     * @param $value
     * @throws InvalidTypeValueException
     */
    public function __construct($value)
    {
        $this->validate($value);
        $this->setValue($value);
    }

    /**
     * @param $value
     * @throws InvalidTypeValueException
     */
    private function validate($value): void
    {
        if(!$this->doValidate($value)){
            throw (new InvalidTypeValueException('Invalid value for "'.__CLASS__.'" type'))
                ->setType($this)
                ->setValue($value);
        }
    }

    protected function doValidate($value): bool
    {
        return true;
    }

    protected function setValue($value): void
    {
        $this->value = $value;
    }

    public function value()
    {
        return $this->value;
    }

    public function equals(ObjectInterface $object): bool
    {
        return (
            ($object instanceof static)
            && $this->value() === $object->value()
        );
    }

    public function __toString(): string
    {
        return (string)$this->value;
    }
}
