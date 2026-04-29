<?php

declare(strict_types = 1);

use App\Models\{Category, Transaction, User};

test('to array', function (): void {
    $category = Category::factory()->create()->fresh();
    expect(array_keys($category->toArray()))->toEqual([
        'id',
        'user_id',
        'name',
        'color',
        'created_at',
        'updated_at',
    ]);
});

it('belongs to user', function (): void {
    $user     = User::factory()->create()->fresh();
    $category = Category::factory()->for($user)->create()->fresh();
    expect($category->user)->toBeInstanceOf(User::class)
        ->and($category->user->is($user))->toBeTrue();
});

it('has many transactions', function (): void {
    $user     = User::factory()->create()->fresh();
    $category = Category::factory()->for($user)->create()->fresh();

    Transaction::factory()->for($user)->create(['category_id' => $category->id]);

    expect($category->transactions)->toHaveCount(1)
        ->and($category->transactions->first())->toBeInstanceOf(Transaction::class);
});
