<?php

declare(strict_types = 1);

namespace App\Actions\Transactions;

use App\Models\Transaction;

class UpdateTransaction
{
    public function __invoke(Transaction $transaction, array $data): Transaction
    {
        $transaction->update([
            'account_id'  => $data['account_id'],
            'category_id' => $data['category_id'],
            'type'        => $data['type'],
            'method'      => $data['method'],
            'amount'      => $data['amount'],
            'description' => $data['description'],
            'date'        => $data['date'],
        ]);

        return $transaction->fresh();
    }
}
