<?php

namespace spec\Modules\Core\Entities\SpecialTypes\Status;

use Modules\Core\Entities\AbstractValueObject;
use Modules\Core\Entities\SpecialTypes\Status\Status;
use Modules\Core\Entities\SpecialTypes\Status\StatusCode;
use PhpSpec\ObjectBehavior;
use function Modules\Core\strEqual;

/**
 * Class StatusSpec
 * @package spec\Modules\Core\Entities\SpecialTypes\Status
 * @mixin Status
 */
class StatusSpec extends ObjectBehavior
{
    /**
     * @var StatusCode
     */
    private $statusCode;
    /**
     * @var \DateTime
     */
    private $dateTime;

    function let()
    {
        $this->statusCode = new StatusCode(1, 'active');
        $this->dateTime = new \DateTime();

        $this->beConstructedWith($this->statusCode, $this->dateTime);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Status::class);
    }

    function it_is_ValueObject()
    {
        $this->shouldBeAnInstanceOf(AbstractValueObject::class);
    }

    function it_should_has_status_code()
    {
        $this->code()->shouldBe(1);
    }

    function it_should_be_stringify()
    {
        $this->__toString()->shouldReturn(strval($this->statusCode));
    }

    function it_should_compares_with_another_Status()
    {
        $status1 = new Status(new StatusCode(2, 'deleted'));
        $status2 = new Status($this->statusCode);

        $this->equals($status1)->shouldReturn(false);
        $this->equals($status2)->shouldReturn(true);
    }

    function it_should_has_status_date()
    {
        $this->date()->shouldBe($this->dateTime);
    }

    function it_should_not_merge_same_status()
    {
        $sameStatus = new Status($this->statusCode, $this->dateTime);
        $status = $this->and($sameStatus);

        $status->equals($sameStatus)->shouldReturn(true);
    }

    function it_should_merge_another_status()
    {
        $status = $this->and(new Status(new StatusCode(2, 'deleted')));
        $status->equals(new Status(new StatusCode(3, 'active,deleted')))->shouldReturn(true);
    }

    function it_should_check_if_it_consists_of_status()
    {
        $active = new Status($this->statusCode);
        $deleted = new Status(new StatusCode(2, 'deleted'));

        $this->is($active)->shouldBe(true);
        $this->is($deleted)->shouldBe(false);

        $status = $this->and($deleted);

        $status->is($active)->shouldBe(true);
        $status->is($deleted)->shouldBe(true);
    }

    function it_should_remove_one_status_from_another()
    {
        $active = new Status($this->statusCode);
        $deleted = new Status(new StatusCode(2, 'deleted'));

        $this->not($deleted)->is($active)->shouldReturn(true);

        $status = $this->not($active);
        $status->is($active)->shouldReturn(false);
        $status->equals(new Status(new StatusCode(0, '')))->shouldReturn(true);

        $status = $status->and($active)->and($deleted);
        $status->is($active)->shouldReturn(true);
        $status->is($deleted)->shouldReturn(true);

        $status->not($active)->is($active)->shouldReturn(false);
        $status->not($active)->is($deleted)->shouldReturn(true);
        $status->not($deleted)->is($deleted)->shouldReturn(false);
    }

    function it_should_merge_another_status_if_current_status_is_empty()
    {
        $this->beConstructedThrough('emptyStatus');

        $this->and(new Status($this->statusCode))->equals(new Status($this->statusCode))->shouldBe(true);
    }
}
