<?php


namespace Modules\Core\Interfaces;


use Illuminate\Contracts\Support\Arrayable;

interface MapInterface extends ObjectInterface, Arrayable, \ArrayAccess, \Iterator
{
    /**
     * Записывает значение $value с ключем $key
     * @param string $key
     * @param $value
     * @return MapInterface
     */
    public function set(string $key, $value): MapInterface;

    /**
     * Возвращает значение по указанному ключу
     * @param string $key
     * @param null $default
     * @return mixed
     */
    public function get(string $key, $default = null);

    /**
     * Удаляет значение по указанном ключу
     * @param string $key
     * @return MapInterface
     */
    public function unset(string $key): MapInterface;

    /**
     * Проверяет установленно ли значение по заданному ключу
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool;

    /**
     * "Запирает" значения заданные ключами $keys делая невозможным их дальнейшеее изменение
     * @param array $keys
     */
    public function lock(array $keys): void;
}
