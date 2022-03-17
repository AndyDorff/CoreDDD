<?php


namespace Modules\Core\Entities\Specifications;


use Modules\Core\Interfaces\Specification\SpecificationInterface;
use Modules\Core\Interfaces\Specification\SpecificationVisitorInterface;

final class NotSpecification extends AbstractSpecification
{
    /**
     * @var SpecificationInterface
     */
    private $wrappedSpec;

    public function __construct(SpecificationInterface $wrappedSpec)
    {
        $this->wrappedSpec = $wrappedSpec;
    }

    public function wrappedSpec(): SpecificationInterface
    {
        return $this->wrappedSpec;
    }

    public function isSatisfiedBy($candidate): bool
    {
        return !$this->wrappedSpec->isSatisfiedBy($candidate);
    }

    public function accept(SpecificationVisitorInterface $visitor, bool $invert = false): void
    {
        $visitor->visitNotSpecification($this);
    }
}