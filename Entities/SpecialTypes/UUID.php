<?php


namespace Modules\Core\Entities\SpecialTypes;


use Illuminate\Support\Str;
use Modules\Core\Entities\BaseTypes\StringType;

class UUID extends StringType
{
    const UUID_LENGTH = 36;

    public function __construct(string $value)
    {
        parent::__construct($value);
    }

    public static function generate()
    {
        return new self(Str::uuid());
    }

    protected function doValidate($value): bool
    {
        return
            $this->length() === self::UUID_LENGTH
            && parent::doValidate($value);
    }
}
