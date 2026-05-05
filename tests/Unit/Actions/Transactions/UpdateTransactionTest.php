<?php

declare(strict_types = 1);

use App\Actions\Transactions\UpdateTransaction;
use App\Enums\{TransactionMethod, TransactionType};
use App\Models\{Account, Category, Transaction, User};

it('updates all transaction fields', function (): void {
    $user        = User::factory()->create()->fresh();
    $account     = Account::factory()->for($user)->create()->fresh();
    $category    = Category::factory()->for($user)->create()->fresh();
    $newAccount  = Account::factory()->for($user)->create()->fresh();
    $newCategory = Category::factory()->for($user)->create()->fresh();

    $transaction = Transaction::factory()->for($user)->create([
        'account_id'  => $account->id,
        'category_id' => $category->id,
        'type'        => TransactionType::EXPENSE->value,
        'method'      => TransactionMethod::PIX->value,
        'amount'      => '100.00',
        'description' => 'Old description.',
        'date'        => '2026-01-01',
    ])->fresh();

    $action  = app(UpdateTransaction::class);
    $updated = $action($transaction, [
        'account_id'  => $newAccount->id,
        'category_id' => $newCategory->id,
        'type'        => TransactionType::INCOME->value,
        'method'      => TransactionMethod::CREDIT->value,
        'amount'      => '250.00',
        'description' => 'Updated description.',
        'date'        => '2026-05-01',
    ]);

    expect($updated)->toBeInstanceOf(Transaction::class)
        ->and($updated->account_id)->toBe($newAccount->id)
        ->and($updated->category_id)->toBe($newCategory->id)
        ->and($updated->type)->toBe(TransactionType::INCOME)
        ->and($updated->method)->toBe(TransactionMethod::CREDIT)
        ->and($updated->amount)->toBe('250.00')
        ->and($updated->description)->toBe('Updated description.');
});

it('persists the updated transaction to the database', function (): void {
    $user     = User::factory()->create()->fresh();
    $account  = Account::factory()->for($user)->create()->fresh();
    $category = Category::factory()->for($user)->create()->fresh();

    $transaction = Transaction::factory()->for($user)->create([
        'account_id'  => $account->id,
        'category_id' => $category->id,
        'amount'      => '100.00',
    ])->fresh();

    $action = app(UpdateTransaction::class);
    $action($transaction, [
        'account_id'  => $account->id,
        'category_id' => $category->id,
        'type'        => TransactionType::EXPENSE->value,
        'method'      => TransactionMethod::CASH->value,
        'amount'      => '999.99',
        'description' => null,
        'date'        => '2026-05-01',
    ]);

    $fresh = Transaction::find($transaction->id);

    expect($fresh->amount)->toBe('999.99');
});

it('returns a fresh instance of the transaction', function (): void {
    $user     = User::factory()->create()->fresh();
    $account  = Account::factory()->for($user)->create()->fresh();
    $category = Category::factory()->for($user)->create()->fresh();

    $transaction = Transaction::factory()->for($user)->create([
        'account_id'  => $account->id,
        'category_id' => $category->id,
    ])->fresh();

    $action = app(UpdateTransaction::class);
    $result = $action($transaction, [
        'account_id'  => $account->id,
        'category_id' => $category->id,
        'type'        => TransactionType::INCOME->value,
        'method'      => TransactionMethod::DEBIT->value,
        'amount'      => '300.00',
        'description' => 'Fresh instance check.',
        'date'        => '2026-05-01',
    ]);

    expect($result->amount)->toBe('300.00')
        ->and($result->description)->toBe('Fresh instance check.');
});

it('preserves the original user_id after updating transaction fields', function (): void {
    $owner    = User::factory()->create()->fresh();
    $account  = Account::factory()->for($owner)->create()->fresh();
    $category = Category::factory()->for($owner)->create()->fresh();

    $transaction = Transaction::factory()->for($owner)->create([
        'account_id'  => $account->id,
        'category_id' => $category->id,
    ])->fresh();

    $action = app(UpdateTransaction::class);
    $action($transaction, [
        'account_id'  => $account->id,
        'category_id' => $category->id,
        'type'        => TransactionType::EXPENSE->value,
        'method'      => TransactionMethod::PIX->value,
        'amount'      => '50.00',
        'description' => null,
        'date'        => '2026-05-01',
    ]);

    expect(Transaction::find($transaction->id)->user_id)->toBe($owner->id);
});
