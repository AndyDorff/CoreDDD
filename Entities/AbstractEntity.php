<?php


namespace Modules\Core\Entities;


use Modules\Core\Interfaces\EntityInterface;
use Modules\Core\Interfaces\HasStateInterface;
use Modules\Core\Interfaces\ObjectInterface;
use Modules\Core\Traits\HasState;

abstract class AbstractEntity extends AbstractObject implements EntityInterface, HasStateInterface
{
    use HasState;

    public function __construct(AbstractIdentity $id)
    {
        $this->setId($id);
    }

    protected function setId(AbstractIdentity $id): void
    {
        $this->state('id', $id);
    }

    public function id(): AbstractIdentity
    {
        return $this->state('id');
    }

    public function hashCode(): string
    {
        return strval($this->id());
    }

    public function equals(ObjectInterface $object): bool
    {
        if($object instanceof EntityInterface){
            return $this->id()->equals($object->id());
        }

        return $object->equals($this);
    }

    public function toArray()
    {
        return $this->state()->toArray();
    }
}
