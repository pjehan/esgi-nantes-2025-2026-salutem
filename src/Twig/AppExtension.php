<?php

namespace App\Twig;

use Twig\Attribute\AsTwigFilter;

class AppExtension
{
    #[AsTwigFilter('dayOfWeek')]
    public function dayOfWeek(int $julianDay, int $mode = CAL_DOW_LONG): string
    {
        return jddayofweek($julianDay - 1, $mode);
    }
}
