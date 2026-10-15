<?php

namespace App\Enums;

enum ServiceStatus: string
{
    case Active = 'active';
    case Isolated = 'isolated';
    case Terminated = 'terminated';

    public function label(): string
    {
        return match ($this) {
            self::Active => 'Aktif',
            self::Isolated => 'Isolir',
            self::Terminated => 'Putus',
        };
    }
}
