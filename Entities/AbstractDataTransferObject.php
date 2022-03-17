<?php

namespace Modules\Core\Entities;


use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

abstract class AbstractDataTransferObject implements Arrayable, Jsonable
{
    public $id = null;

    public function __construct(array $properties = [])
    {
        $this->fill($properties);
    }

    public function fill(array $properties): void
    {
        foreach ($properties as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    public function version(): string
    {
        return crc32(serialize($this->toArray()));
    }

    public function toArray(): array
    {
        return $this->convertToArray($this, true);
    }

    private function convertToArray($value, $self = false)
    {
        switch(true){
            case (($value instanceof Arrayable) && !$self):
                return $this->convertToArray($value->toArray());
            case is_object($value):
                return array_map([$this, 'convertToArray'], get_object_vars($value));
            case is_array($value):
                return array_map([$this, 'convertToArray'], $value);
            default: return $value;
        }
    }

    public function toJson($options = 0): string
    {
        return json_encode($this->toArray(), $options);
    }
}