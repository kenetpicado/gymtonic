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
                'label' => 'Mes',
                'key' => self::MONTH,
            ],
            [
                'label' => 'Quincena',
                'key' => self::FORTNIGHT,
            ],
            [
                'label' => 'Semana',
                'key' => self::WEEK,
            ],
            [
                'label' => 'Dia',
                'key' => self::DAY,
            ]
        ];
    }

    public static function getLabel(string $key): string
    {
        $periods = self::get();

        foreach ($periods as $period) {
            if ($period['key'] === $key) {
                return $period['label'];
            }
        }

        return '';
    }
}
