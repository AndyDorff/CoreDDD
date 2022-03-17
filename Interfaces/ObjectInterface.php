<?php


namespace Modules\Core\Interfaces;


use Modules\Core\Interfaces\StringifyInterface;

interface ObjectInterface extends StringifyInterface
{
    /**
     * Проверяет идентичность между текущим объектом и указанным
     * @param ObjectInterface $object
     * @return bool
     */
    public function equals(ObjectInterface $object): bool;

    /**
     * Возвращает hash код объекта
     * @return string
     */
    public function hashCode(): string;
}
