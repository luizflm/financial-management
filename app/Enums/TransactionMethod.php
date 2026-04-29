<?php

declare(strict_types = 1);

namespace App\Enums;

enum TransactionMethod: string
{
    case PIX    = 'pix';
    case CASH   = 'cash';
    case DEBIT  = 'debit';
    case CREDIT = 'credit';

    public function label(): string
    {
        return match ($this) {
            self::PIX    => 'Pix',
            self::CASH   => 'Cash',
            self::DEBIT  => 'Debit',
            self::CREDIT => 'Credit',
        };
    }
}
