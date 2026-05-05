<?php

declare(strict_types = 1);

namespace App\Actions\Transactions;

use App\Models\Transaction;

class CreateTransaction
{
    public function __invoke(array $data, int $userId): Transaction
    {
        /** @var Transaction $transaction */
        $transaction = Transaction::create([
            ...$data,
            'user_id' => $userId,
        ]);

        return $transaction;
    }
}
