<?php

namespace App\Enums;

enum ClientStatus: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';

    public function message(): string
    {
        return match($this) {
            self::ACTIVE => 'الحساب نشط.',
            self::INACTIVE => 'الحساب غير مفعل بعد.',
        };
    }
}
