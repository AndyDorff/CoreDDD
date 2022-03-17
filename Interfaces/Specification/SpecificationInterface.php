<?php


namespace Modules\Core\Interfaces\Specification;


interface SpecificationInterface
{
    public function isSatisfiedBy($candidate): bool;
    public function accept(SpecificationVisitorInterface $visitor, bool $invert = false): void;
}