<?php


namespace Modules\Core\Interfaces\Specification;


use Modules\Core\Entities\Specifications\AndSpecification;
use Modules\Core\Entities\Specifications\NotSpecification;
use Modules\Core\Entities\Specifications\OrSpecification;

interface SpecificationVisitorInterface
{
    public function visitAndSpecification(AndSpecification $spec): void;
    public function visitOrSpecification(OrSpecification $spec): void;
    public function visitNotSpecification(NotSpecification $spec): void;
}