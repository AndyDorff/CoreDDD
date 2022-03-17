<?php


namespace Modules\Core\Entities;


use Modules\Core\Entities\SpecialTypes\Map;
use Modules\Core\Interfaces\MapInterface;
use Modules\Core\Interfaces\ObjectInterface;

class State extends AbstractObject implements MapInterface
{
    private $originState;
    private $currentState;

    private $changes = [];
    private $changed = [];

    public function __construct(array $values = [], array $locked = [])
    {
        $this->setState(new Map($values));
        $this->lock($locked);
    }

    public static function fromMap(MapInterface $currentState)
    {
        $state = new static();
        $state->setState($currentState);

        return $state;
    }

    protected function setState(MapInterface $map)
    {
        $this->currentState = $map;
        $this->reset();
    }

    public function reset(): void
    {
        $this->originState = $this->currentState;
        $this->changes = [];
        $this->changed = [];
    }

    public function origin(): MapInterface
    {
        return $this->originState;
    }

    public function set(string $key, $value): MapInterface
    {
        if(!$this->originState->has($key)){
            $this->originState = $this->originState->set($key, $value);
        }
        else{
            $this->changes[] = [$key, $value];
            $this->changed[] = $key;
        }
        $this->currentState = $this->currentState->set($key, $value);

        return $this;
    }

    public function get(string $key, $default = null)
    {
        return $this->currentState->get($key);
    }

    public function unset(string $key): MapInterface
    {
        $this->currentState = $this->currentState->unset($key);

        return $this;
    }

    public function has(string $key): bool
    {
        return $this->currentState->has($key);
    }

    public function lock(array $keys): void
    {
        $this->currentState->lock($keys);
    }

    public function isChanged(string $key = null): bool
    {
        return $key ? in_array($key, $this->changed) : !empty($this->changed);
    }

    public function toArray()
    {
        return $this->currentState->toArray();
    }

    public function equals(ObjectInterface $object): bool
    {
        return $this->currentState->equals($object);
    }

    public function offsetExists($offset)
    {
        return $this->currentState->offsetExists($offset);
    }

    public function offsetGet($offset)
    {
        return $this->currentState->offsetGet($offset);
    }

    public function offsetSet($offset, $value)
    {
        $this->currentState->offsetSet($offset, $value);
    }

    public function offsetUnset($offset)
    {
        $this->currentState->offsetUnset($offset);
    }

    public function current()
    {
        return $this->currentState->current();
    }

    public function next()
    {
        $this->currentState->next();
    }

    public function key()
    {
        return $this->currentState->key();
    }

    public function valid()
    {
        return $this->currentState->valid();
    }

    public function rewind()
    {
        $this->currentState->rewind();
    }
}
