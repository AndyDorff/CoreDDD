<?php


namespace Modules\Core\Traits;


use Modules\Core\Entities\SpecialTypes\Map;
use Modules\Core\Entities\State;
use Modules\Core\Interfaces\MapInterface;

/**
 * Trait StateTrait
 * @package Modules\Core\Traits
 */
trait HasState
{
    /**
     * @var State
     */
    private $state;

    protected function initState(array $values = [], array $locked = []): State
    {
        $this->state = new State($values, $locked);

        return $this->state;
    }

    protected function initReadOnlyState(array $values = []): void
    {
        $this->state = State::fromMap(Map::readonly($values));
    }

    protected function initLockedState(array $values = []): void
    {
        $this->state = State::fromMap(Map::locked($values));
    }

    public function getState(): State
    {
        return $this->state();
    }

    /**
     * @param string|null $key
     * @param Map| $value
     * @param bool $valueIsNull
     * @return mixed|State
     */
    protected function state(string $key = null, $value = null, $valueIsNull = false)
    {
        if(is_null($this->state)) {
            $this->initState();
        }
        if(is_null($key)){
            return $this->state;
        }
        elseif(is_null($value)){
            if($valueIsNull){
                $this->state = $this->state->set($key, $value);
                return $this->state;
            }
            else{
                return $this->state[$key];
            }
        }
        else{
            $this->state = $this->state->set($key, $value);
            return $this->state;
        }
    }

    public function getOrigin(): MapInterface
    {
        return $this->state->origin();
    }
}
