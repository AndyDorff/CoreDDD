<?php


namespace Modules\Core\Interfaces;


use Illuminate\Contracts\Support\Arrayable;
use Modules\Core\Entities\AbstractIdentity;

interface EntityInterface extends ObjectInterface, Arrayable
{
    public function id(): AbstractIdentity;
}
