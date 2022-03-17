<?php


namespace Modules\Core\Entities\Specifications;


use Modules\Core\Interfaces\Specification\SpecificationInterface;
use Modules\Core\Interfaces\Specification\SpecificationVisitorInterface;

final class AndSpecification extends AbstractSpecification
{
    /**
     * @var SpecificationInterface
     */
    private $leftSpec;
    /**
     * @var SpecificationInterface
     */
    private $rightSpec;

    public function __construct(SpecificationInterface $leftSpec, SpecificationInterface $rightSpec)
    {
        $this->leftSpec = $leftSpec;
        $this->rightSpec = $rightSpec;
    }

    public function leftSpec(): SpecificationInterface
    {
        return $this->leftSpec;
    }

    public function rightSpec(): SpecificationInterface
    {
        return $this->rightSpec;
    }

    public function isSatisfiedBy($candidate): bool
    {
        return $this->leftSpec->isSatisfiedBy($candidate) && $this->rightSpec->isSatisfiedBy($candidate);
    }

    public function accept(SpecificationVisitorInterface $visitor, bool $invert = false): void
    {
        $visitor->visitAndSpecification($this);
    }
}