<?php


namespace Modules\Core\Entities\SpecialTypes;


use Illuminate\Contracts\Support\Arrayable;
use Modules\Core\Entities\BaseTypes\BaseType;
use Modules\Core\Exceptions\CoreException;
use Modules\Core\Interfaces\MapInterface;
use Modules\Core\Interfaces\ObjectInterface;
use Modules\Core\Interfaces\StringifyInterface;

final class Map extends BaseType implements MapInterface
{
    const MODE_READONLY = 0;
    const MODE_SETTABLE = 1;
    const MODE_CHANGEABLE = 2;
    const MODE_REMOVABLE = 4;

    private $mode;
    private $values;
    private $lockedValues = [];

    public function __construct(
        array $value = [],
        int $mode = self::MODE_SETTABLE | self::MODE_CHANGEABLE | self::MODE_REMOVABLE)
    {
        parent::__construct($value);
        $this->mode = $mode;
    }

    /**
     * @param array $value
     * @return static
     * @throws \Modules\Core\Exceptions\InvalidTypeValueException
     */
    public static function readonly(array $value = [])
    {
        return new static($value, self::MODE_READONLY);
    }

    public static function locked(array $value = [])
    {
        return new static($value, self::MODE_SETTABLE);
    }

    public function lock(array $keys): void
    {
        $this->lockedValues = array_merge($this->lockedValues, array_map('strval', $keys));
    }

    public function isValueLocked(string $key): bool
    {
        return (!$this->isChangeable() || in_array($key, $this->lockedValues));
    }

    public function replicate(array $value = null, int $mode = null)
    {
        $value = $value ?? $this->value();
        $mode = $mode ?? $this->mode();

        return new static($value, $mode);
    }

    public function mode(): int
    {
        return $this->mode;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function set(string $key, $value): MapInterface
    {
        $map = $this->value();
        $val = $this->get($key);
        if (is_null($val)){
            if(!$this->isSettable()){
                throw new CoreException('Method "'.__METHOD__.'" is available in SETTABLE mode');
            }
        } elseif (!$this->isChangeable()){
            throw new CoreException('Method "'.__METHOD__.'" is available in CHANGEABLE mode');
        } elseif ($this->isValueLocked($key)){
            throw new CoreException('Map value under key "'.$key.'" is locked');
        } elseif ($val === $value){
            return $this;
        }

        $map[$key] = $value;

        return $this->replicate($map);
    }

    public function get(string $key, $default = null)
    {
        return ($this->has($key)
            ? $this->value()[$key]
            : $default
        );
    }

    /**
     * @param string $key
     * @return $this
     */
    public function unset(string $key): MapInterface
    {
        if(!$this->isRemovable()){
            throw new CoreException('Method "'.__METHOD__.'" is available in REMOVABLE mode');
        }
        elseif($this->has($key)){
            $map = $this->value();
            unset($map[$key]);

            return $this->replicate($map);
        }

        return $this;
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->value());
    }

    public function isRemovable(): bool
    {
        return (($this->mode & self::MODE_REMOVABLE) === self::MODE_REMOVABLE);
    }

    public function isChangeable(): bool
    {
        return (($this->mode & self::MODE_CHANGEABLE) === self::MODE_CHANGEABLE);
    }

    public function isSettable(): bool
    {
        return (($this->mode & self::MODE_SETTABLE) === self::MODE_SETTABLE);
    }

    public function isReadonly(): bool
    {
        return (($this->mode & self::MODE_READONLY) === self::MODE_READONLY);
    }

    public function toArray(): array
    {
        $values = [];
        foreach($this as $key => $value){
            $values[$key] = $this->expandValue($value);
        }

        return $values;
    }

    private function expandValue($value)
    {
        $result = $value;
        if(is_object($value)){
            if($value instanceof Arrayable){
                $result = $this->extractArray($value);
            }
            elseif(is_callable([$value, 'toArray'])){
                $result = $this->extractArray($value);
            }
            elseif($value instanceof StringifyInterface){
                $result = strval($value);
            }
        } elseif(is_iterable($value)) {
            $result = [];
            foreach($value as $key => $val){
                $result[$key] = $this->expandValue($val);
            }
        }

        return $result;
    }

    private function extractArray($object)
    {
        $array = $object->toArray();
        if(count($array) === 1){
            return current($array);
        }

        return $array;
    }

    public function equals(ObjectInterface $object): bool
    {
        $equals = false;
        if($object instanceof MapInterface){
            $equals = true;
            foreach($this->value() as $key => $value){
                if($equals = $object->has($key)){
                    $objectValue = $object->get($key);
                    $equals = (
                        is_a($value, ObjectInterface::class)
                        && is_a($objectValue, ObjectInterface::class)
                    )
                        ? $value->equals($objectValue)
                        : $value === $objectValue
                    ;
                }
                if(!$equals){
                    break;
                }
            }
        }

        return $equals;
    }

    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    public function offsetSet($offset, $value)
    {
        return $this->set($offset, $value);
    }

    public function offsetUnset($offset)
    {
        $this->unset($offset);
    }

    public function current()
    {
        return current($this->values);
    }

    public function next()
    {
        next($this->values);
    }

    public function key()
    {
        return key($this->values);
    }

    public function valid()
    {
        return !is_null($this->key());
    }

    public function rewind()
    {
        $this->values = $this->value();
    }
}
