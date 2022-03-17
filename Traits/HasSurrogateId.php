<?php


namespace Modules\Core\Traits;


use Modules\Core\Entities\BaseTypes\BaseType;

trait HasSurrogateId
{
    /**
     * @var BaseType
     */
    private $surrogateId;

    public function surrogateId(): ?BaseType
    {
        return $this->surrogateId;
    }

    public function setSurrogateId(BaseType $surrogateId): void
    {
        if($this->surrogateId){
            throw new \DomainException('Surrogate id has already set for "'.get_class($this).'" class');
        }

        $this->surrogateId = $surrogateId;
    }
}
