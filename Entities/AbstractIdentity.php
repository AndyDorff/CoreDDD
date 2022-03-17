<?php


namespace Modules\Core\Entities;


use Modules\Core\Traits\HasSurrogateId;

abstract class AbstractIdentity extends AbstractValueObject
{
    use HasSurrogateId;

    public function toArray()
    {
        $array = parent::toArray();
        $array['surrogateId'] = (string)$this->surrogateId();

        return $array;
    }
}
