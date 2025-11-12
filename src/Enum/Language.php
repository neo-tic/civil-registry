<?php

namespace App\Enum;

enum Language: string
{
    case French = 'fr';
    case Arabic = 'ar';
    case Both = 'both';

    public static function fromQuery(?string $value): self
    {
        if ($value === null || $value === '') {
            return self::French;
        }

        $normalised = strtolower($value);

        return match ($normalised) {
            self::French->value => self::French,
            self::Arabic->value => self::Arabic,
            self::Both->value => self::Both,
            default => throw new \InvalidArgumentException(sprintf('Unsupported language option "%s".', $value)),
        };
    }
}

