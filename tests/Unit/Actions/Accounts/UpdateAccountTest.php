<?php

declare(strict_types = 1);

use App\Actions\Accounts\UpdateAccount;
use App\Models\{Account, User};

it('updates the account name', function (): void {
    $user    = User::factory()->create()->fresh();
    $account = Account::factory()->for($user)->create(['name' => 'Old Name'])->fresh();

    $action  = app(UpdateAccount::class);
    $updated = $action($account, ['name' => 'New Name']);

    expect($updated)->toBeInstanceOf(Account::class)
        ->and($updated->name)->toBe('New Name');
});

it('persists the updated account to the database', function (): void {
    $user    = User::factory()->create()->fresh();
    $account = Account::factory()->for($user)->create(['name' => 'Old Name'])->fresh();

    $action = app(UpdateAccount::class);
    $action($account, ['name' => 'Updated Name']);

    expect(Account::find($account->id)->name)->toBe('Updated Name');
});

it('returns a fresh instance of the account', function (): void {
    $user    = User::factory()->create()->fresh();
    $account = Account::factory()->for($user)->create(['name' => 'Original'])->fresh();

    $action = app(UpdateAccount::class);
    $result = $action($account, ['name' => 'Fresh']);

    expect($result->name)->toBe('Fresh');
});

it('preserves the original user_id after updating account fields', function (): void {
    $owner   = User::factory()->create()->fresh();
    $account = Account::factory()->for($owner)->create(['name' => 'My Account'])->fresh();

    $action = app(UpdateAccount::class);
    $action($account, ['name' => 'Renamed']);

    expect(Account::find($account->id)->user_id)->toBe($owner->id);
});
