<?php

declare(strict_types = 1);

use App\Enums\TransactionMethod;

it('has the correct string value for Pix', function (): void {
    expect(TransactionMethod::PIX->value)->toBe('pix');
});

it('has the correct string value for Cash', function (): void {
    expect(TransactionMethod::CASH->value)->toBe('cash');
});

it('has the correct string value for Debit', function (): void {
    expect(TransactionMethod::DEBIT->value)->toBe('debit');
});

it('has the correct string value for Credit', function (): void {
    expect(TransactionMethod::CREDIT->value)->toBe('credit');
});

it('returns the correct label for Pix', function (): void {
    expect(TransactionMethod::PIX->label())->toBe('Pix');
});

it('returns the correct label for Cash', function (): void {
    expect(TransactionMethod::CASH->label())->toBe('Cash');
});

it('returns the correct label for Debit', function (): void {
    expect(TransactionMethod::DEBIT->label())->toBe('Debit');
});

it('returns the correct label for Credit', function (): void {
    expect(TransactionMethod::CREDIT->label())->toBe('Credit');
});

it('can be instantiated from a raw string value', function (string $value, TransactionMethod $expected): void {
    expect(TransactionMethod::from($value))->toBe($expected);
})->with([
    'pix string'    => ['pix', TransactionMethod::PIX],
    'cash string'   => ['cash', TransactionMethod::CASH],
    'debit string'  => ['debit', TransactionMethod::DEBIT],
    'credit string' => ['credit', TransactionMethod::CREDIT],
]);
