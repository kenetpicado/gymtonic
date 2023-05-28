<?php

namespace App\Enums;

use Illuminate\Validation\Rules\Enum;

class PeriodEnum extends Enum
{
    const DAY = '1';
    const WEEK = '7';
    const FORTNIGHT = '15';
    const MONTH = '30';

    public static function get(): array
    {
        return [
            [
                'period_label' => 'Dia',
                'period' => self::DAY,
            ],
            [
                'period_label' => 'Semana',
                'period' => self::WEEK,
            ],
            [
                'period_label' => 'Quincena',
                'period' => self::FORTNIGHT,
            ],
            [
                'period_label' => 'Mes',
                'period' => self::MONTH,
            ],
        ];
    }

    public static function getLabel(string $key): string
    {
        $periods = self::get();

        foreach ($periods as $period) {
            if ($period['period'] == $key) {
                return $period['period_label'];
            }
        }

        return '';
    }
}
