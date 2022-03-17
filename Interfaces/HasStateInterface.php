<?php


namespace Modules\Core\Interfaces;


use Modules\Core\Entities\State;

interface HasStateInterface
{
    public function getState(): State;
}
