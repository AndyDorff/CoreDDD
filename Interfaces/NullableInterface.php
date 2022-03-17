<?php


namespace Modules\Core\Interfaces;


interface NullableInterface
{
    /**
     * Фабричный метод для создания Null-объекта
     * @return static
     */
    public static function nullable();

    /**
     * Проверяет является ли объект Null-объектом
     * @return bool
     */
    public function isNull():bool;
}
