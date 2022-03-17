<?php


namespace Modules\Core\Entities;


use Modules\Core\Interfaces\ObjectInterface;

abstract class AbstractObject implements ObjectInterface
{
    public function hashCode(): string
    {
        return spl_object_hash($this);
    }

    public function __toString(): string
    {
        return get_class($this).'@'.$this->hashCode();
    }
}
