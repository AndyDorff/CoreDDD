<?php


namespace Modules\Core\Entities;


use Illuminate\Contracts\Support\Arrayable;
use Modules\Core\Entities\SpecialTypes\Map;

abstract class AbstractValueObject extends AbstractObject implements Arrayable
{
    /**
     * @var Map
     */
    private $attributes;

    protected function initAttributes(array $attributes = [])
    {
        $this->attributes = Map::locked($attributes);
    }

    /**
     * @param string|null $key
     * @param null $value
     * @param bool $valueIsNull
     * @return mixed|Map
     */
    protected function attribute(string $key = null, $value = null, $valueIsNull = false)
    {
        if(is_null($this->attributes)) {
            $this->initAttributes();
        }
        if(is_null($key)){
            return $this->attributes;
        }
        elseif(is_null($value)){
            if($valueIsNull){
                $this->attributes = $this->attributes->set($key, $value);
                return $this->attributes;
            }
            else{
                return $this->attributes[$key];
            }
        }
        else{
            $this->attributes = $this->attributes->set($key, $value);
            return $this->attributes;
        }
    }

    public function toArray()
    {
        return $this->attribute()->toArray();
    }
}
