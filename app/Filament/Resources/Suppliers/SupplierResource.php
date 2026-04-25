<?php

namespace App\Filament\Resources\Suppliers;

use App\Filament\Resources\Suppliers\Pages\CreateSupplier;
use App\Filament\Resources\Suppliers\Pages\EditSupplier;
use App\Filament\Resources\Suppliers\Pages\ListSuppliers;
use App\Filament\Resources\Suppliers\Schemas\SupplierForm;
use App\Filament\Resources\Suppliers\Tables\SuppliersTable;
use App\Models\Supplier;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;

class SupplierResource extends Resource
{
    protected static ?string $model = Supplier::class;
    protected static ?string $pluralModelLabel = 'Supplier';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

     public static function canViewAny(): bool
    {
        return auth()->user()->can('view supplier');
    }

    public static function canCreate(): bool
    {
        return auth()->user()->can('create supplier');
    }

    public static function canEdit($record): bool
    {
        return auth()->user()->can('edit supplier');
    }

    public static function canDelete($record): bool
    {
        return auth()->user()->can('delete supplier');
    }
    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->can('view supplier') ?? false;
    }


    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_supplier')
                    ->required(),
                TextInput::make('alamat')
                    ->nullable(),
                TextInput::make('telepon')
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return SuppliersTable::configure($table);
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
            'index' => ListSuppliers::route('/'),
            'create' => CreateSupplier::route('/create'),
            'edit' => EditSupplier::route('/{record}/edit'),
        ];
    }
}
