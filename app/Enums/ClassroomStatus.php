<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class ClassroomStatus extends Enum
{
    const OptionOne = 0;
    const OptionTwo = 1;
    const OptionThree = 2;
    public static function trans($value)
    {
        if ($value == 0) return "Đang hoạt động";
        if ($value == 1) return "Đã kết thúc";
        if ($value == 2) return "Đang bảo lưu";
    }
}
