<?php


namespace Modules\Core\Entities\Specifications;


use Modules\Core\Interfaces\Specification\SpecificationInterface;
use Modules\Core\Interfaces\Specification\SpecificationVisitorInterface;

abstract class AbstractSpecification implements SpecificationInterface
{
    public function and(SpecificationInterface $spec): AndSpecification
    {
        return new AndSpecification($this, $spec);
    }

    public function or(SpecificationInterface $spec): OrSpecification
    {
        return new OrSpecification($this, $spec);
    }

    public function not(): NotSpecification
    {
        return new NotSpecification($this);
    }

    public function accept(SpecificationVisitorInterface $visitor, bool $invert = false): void
    {
    }
}