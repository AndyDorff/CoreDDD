<?php


namespace Modules\Core\Interfaces;


interface StringifyInterface
{
    /**
     * Возвращает строковое представление объекта
     * @return string
     */
    public function __toString(): string;
}
