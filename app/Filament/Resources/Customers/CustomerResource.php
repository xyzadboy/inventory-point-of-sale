<?php

namespace App\Filament\Resources\Customers;

use App\Filament\Resources\Customers\Pages\CreateCustomer;
use App\Filament\Resources\Customers\Pages\EditCustomer;
use App\Filament\Resources\Customers\Pages\ListCustomers;
use App\Filament\Resources\Customers\Schemas\CustomerForm;
use App\Filament\Resources\Customers\Tables\CustomersTable;
use App\Models\Customer;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Customer';

    public static function canViewAny(): bool
    {
        return auth()->user()->can('view customer');
    }

    public static function canCreate(): bool
    {
        return auth()->user()->can('create customer');
    }

    public static function canEdit($record): bool
    {
        return auth()->user()->can('edit customer');
    }

    public static function canDelete($record): bool
    {
        return auth()->user()->can('delete customer');
    }
    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->can('view customer') ?? false;
    }


    public static function form(Schema $schema): Schema
    {
        return $schema
        ->components([
            TextInput::make('nama_customer')
                ->label('Nama Customer')
                ->required()
                ->maxLength(255),
            TextInput::make('alamat')
                ->label('Alamat')
                ->required()
                ->maxLength(255),
            TextInput::make('telepon')
                ->label('Telepon')
                ->required()
                ->maxLength(20),
        ]);
    }

    public static function table(Table $table): Table
    {
        return CustomersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCustomers::route('/'),
            'create' => CreateCustomer::route('/create'),
            'edit' => EditCustomer::route('/{record}/edit'),
        ];
    }
}
