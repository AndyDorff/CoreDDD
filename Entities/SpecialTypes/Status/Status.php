<?php


namespace Modules\Core\Entities\SpecialTypes\Status;


use DateTime;
use Modules\Core\Entities\AbstractValueObject;
use Modules\Core\Interfaces\ObjectInterface;

final class Status extends AbstractValueObject
{
    public function __construct(StatusCode $code, DateTime $dateTime = null)
    {
        $this->initAttributes([
            'code' => $code,
            'date' => $dateTime ?? new DateTime()
        ]);
    }

    public static function emptyStatus(DateTime $dateTime = null): self
    {
        return new self(new StatusCode(0, ''), $dateTime);
    }

    public function code(): int
    {
        return $this->getCode()->code();
    }

    private function getCode(): StatusCode
    {
        return $this->attribute('code');
    }

    public function date(): DateTime
    {
        return $this->attribute('date');
    }

    public function and(Status $status): Status
    {
        if($this->is($status)){
            return $this;
        }

        $name = strval($this);
        $name = empty($name) ? strval($status) : ($name.','.$status);
        $code = $this->code() | $status->code();

        return new Status(new StatusCode($code, $name));
    }

    public function is(Status $status): bool
    {
        return (($this->code() & $status->code()) === $status->code());
    }

    public function not(Status $status): Status
    {
        if(!$this->is($status)){
            return $this;
        }

        $code = $this->code() ^ $status->code();
        $name = $this->removeStatusName($status);

        return new Status(new StatusCode($code, $name));
    }

    private function removeStatusName(string $statusName)
    {
        $names = explode(',', $this);
        if($names){
            $names = implode('', array_filter($names, function($name) use ($statusName){
                return ($name !== $statusName);
            }));
        }
        else{
            $names = '';
        }

        return $names;
    }

    public function equals(ObjectInterface $object): bool
    {
        return (
            ($object instanceof self)
            && $this->getCode()->equals($object->getCode())
        );
    }

    public function __toString(): string
    {
        return strval($this->getCode());
    }
}
