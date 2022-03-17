<?php


namespace Modules\Core\Entities\SpecialTypes\Status;


use Modules\Core\Entities\AbstractValueObject;
use Modules\Core\Interfaces\ObjectInterface;
use function Modules\Core\strEqual;

final class StatusCode extends AbstractValueObject
{
    public function __construct(int $code, string $name)
    {
        $this->attribute('code', $code);
        $this->attribute('name', $name);
    }

    public static function fromString(string $name, ?int $code = null): self
    {
        return new self($code ?? self::nameToCode($name), $name);
    }

    private static function nameToCode(string $name): int
    {
        return crc32($name);
    }

    public function code(): int
    {
        return $this->attribute('code');
    }

    public function __toString(): string
    {
        return $this->attribute('name');
    }

    public function equals(ObjectInterface $object): bool
    {
        return (
            ($object instanceof self)
            && $this->code() === $object->code()
            && strEqual($this, $object)
        );
    }
}
