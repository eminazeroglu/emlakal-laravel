<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class MenuTypeEnum extends Enum
{
    const Header = 'header';
    const Footer = 'footer';

    public static function getDescription($value): string
    {
        return match ($value) {
            self::Header => 'Header',
            self::Footer => 'Footer',
            default => self::getKey($value),
        };
    }
}
