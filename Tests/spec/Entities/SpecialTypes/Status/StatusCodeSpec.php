<?php

namespace spec\Modules\Core\Entities\SpecialTypes\Status;

use Modules\Core\Entities\AbstractValueObject;
use Modules\Core\Entities\SpecialTypes\Status\StatusCode;
use PhpSpec\ObjectBehavior;

/**
 * Class StatusCodeSpec
 * @package spec\Modules\Core\Entities\SpecialTypes\Status
 * @mixin StatusCode
 */
class StatusCodeSpec extends ObjectBehavior
{
    private $code;
    private $name;

    function let()
    {
        $this->code = 1;
        $this->name = 'active';

        $this->beConstructedWith($this->code, $this->name);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(StatusCode::class);
    }

    function it_is_ValueObject()
    {
        $this->shouldBeAnInstanceOf(AbstractValueObject::class);
    }

    function it_should_has_code()
    {
        $this->code()->shouldBe($this->code);
    }

    function it_should_converts_to_string()
    {
        $this->__toString()->shouldReturn($this->name);
    }

    function it_should_compares_with_another_StatusCode()
    {
        $statusCode1 = new StatusCode($this->code, $this->name);
        $statusCode2 = new StatusCode(2, 'deleted');
        $statusCode3 = new StatusCode(2, $this->name);
        $statusCode4 = new StatusCode($this->code, 'deleted');

        $this->equals($statusCode1)->shouldReturn(true);
        $this->equals($statusCode2)->shouldReturn(false);
        $this->equals($statusCode3)->shouldReturn(false);
        $this->equals($statusCode4)->shouldReturn(false);
    }

}
