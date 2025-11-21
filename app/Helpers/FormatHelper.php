<?php

declare(strict_types=1);

namespace App\Helpers;

class FormatHelper
{
    public static function formatTimeLimit(int $minutes): string
    {
        $hours = floor($minutes / 60);
        $minutes = $minutes % 60;

        $hourText = ['hour', 'hours', 'hours'];
        $minuteText = ['minute', 'minutes', 'minutes'];

        if (app()->getLocale() === 'ru') {
            $hourText = ['час', 'часа', 'часов'];
            $minuteText = ['минута', 'минут', 'минут'];
        }

        if ($hours < 1) {
            return $minutes . ' ' . changeWordEnding($minutes, $minuteText);
        } elseif ($minutes < 1) {
            return $hours . ' ' . changeWordEnding($hours, $hourText);
        }
        return $hours . ' ' . changeWordEnding($hours, $hourText) . ' ' . $minutes . ' ' . changeWordEnding($minutes, $minuteText);
    }
}