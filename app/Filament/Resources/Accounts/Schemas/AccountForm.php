<?php

declare(strict_types = 1);

namespace App\Filament\Resources\Accounts\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AccountForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(100),
            ]);
    }
}
