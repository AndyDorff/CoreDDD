<?php


namespace Modules\Core\Entities\Specifications\Visitors;


use Illuminate\Database\Query\Builder;
use Modules\Core\Entities\Specifications\AndSpecification;
use Modules\Core\Entities\Specifications\NotSpecification;
use Modules\Core\Entities\Specifications\OrSpecification;
use Modules\Core\Interfaces\Specification\SpecificationVisitorInterface;

final class EloquentSpecificationVisitor implements SpecificationVisitorInterface
{
    /**
     * @var Builder
     */
    private $query;

    public function __construct(Builder $query)
    {
        $this->setQuery($query);
    }

    protected function setQuery(Builder $query): void
    {
        $this->query = $query;
    }

    public function query(): Builder
    {
        return $this->query;
    }

    protected function replicate(Builder $query = null): EloquentSpecificationVisitor
    {
        return new static($query ?? $this->query());
    }

    public function visitAndSpecification(AndSpecification $spec): void
    {
        $spec->leftSpec()->accept($this);
        $spec->rightSpec()->accept($this);
    }

    public function visitOrSpecification(OrSpecification $spec): void
    {
        $this->query->where(function ($query) use ($spec) {
            $visitor = $this->replicate($query);
            $spec->leftSpec()->accept($visitor);
            $query->orWhere(function ($query) use ($spec) {
                $visitor = $this->replicate($query);
                $spec->rightSpec()->accept($visitor);
            });
        });
    }

    public function visitNotSpecification(NotSpecification $spec): void
    {
        $spec->wrappedSpec()->accept($this, true);
    }
}