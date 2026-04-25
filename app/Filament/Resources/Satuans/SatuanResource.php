<?php

namespace App\Filament\Resources\Satuans;

use App\Filament\Resources\Satuans\Pages\CreateSatuan;
use App\Filament\Resources\Satuans\Pages\EditSatuan;
use App\Filament\Resources\Satuans\Pages\ListSatuans;
use App\Filament\Resources\Satuans\Schemas\SatuanForm;
use App\Filament\Resources\Satuans\Tables\SatuansTable;
use App\Models\Satuan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;

class SatuanResource extends Resource
{
    protected static ?string $model = Satuan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static ?string $pluralModelLabel = 'Satuan';

     public static function canViewAny(): bool
    {
        return auth()->user()->can('view produk');
    }

    public static function canCreate(): bool
    {
        return auth()->user()->can('create satuan');
    }

    public static function canEdit($record): bool
    {
        return auth()->user()->can('edit satuan');
    }

    public static function canDelete($record): bool
    {
        return auth()->user()->can('delete satuan');
    }
    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->can('view satuan') ?? false;
    }



    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_satuan')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return SatuansTable::configure($table);
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
            'index' => ListSatuans::route('/'),
            'create' => CreateSatuan::route('/create'),
            'edit' => EditSatuan::route('/{record}/edit'),
        ];
    }
}
