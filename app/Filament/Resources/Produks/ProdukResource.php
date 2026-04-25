<?php

namespace App\Filament\Resources\Produks;

use App\Filament\Resources\Produks\Pages\CreateProduk;
use App\Filament\Resources\Produks\Pages\EditProduk;
use App\Filament\Resources\Produks\Pages\ListProduks;
use App\Filament\Resources\Produks\Schemas\ProdukForm;
use App\Filament\Resources\Produks\Tables\ProduksTable;
use App\Models\Produk;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;

class ProdukResource extends Resource
{
    protected static ?string $model = Produk::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function canViewAny(): bool
    {
        return auth()->user()->can('view produk');
    }

    public static function canCreate(): bool
    {
        return auth()->user()->can('create produk');
    }

    public static function canEdit($record): bool
    {
        return auth()->user()->can('edit produk');
    }

    public static function canDelete($record): bool
    {
        return auth()->user()->can('delete produk');
    }
    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->can('view produk') ?? false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
        ->components([
            TextInput::make('nama_produk')
                ->label('Nama Produk')
                ->required()
                ->maxLength(255),
            TextInput::make('sku')
                ->label('SKU')
                ->required()
                ->unique(ignoreRecord: true)
                ->maxLength(100),
            Select::make('kategori_id')
                ->label('Kategori')
                ->relationship('kategori', 'nama_kategori')
                ->required(),
            Select::make('satuan_id')
                ->label('Satuan')
                ->relationship('satuan', 'nama_satuan')
                ->required(),
            Select::make('supplier_id')
                ->label('Supplier')
                ->relationship('supplier', 'nama_supplier')
                ->required(),
            TextInput::make('harga_beli')
                ->label('Harga Beli')
                ->required()
                ->numeric()
                ->minValue(0),
            TextInput::make('harga_jual')
                ->label('Harga Jual')
                ->required()
                ->numeric()
                ->minValue(0),
            TextInput::make('stok')
                ->label('Stok')
                ->required()
                ->numeric()
                ->minValue(0),
        ]);
    }

    public static function table(Table $table): Table
    {
        return ProduksTable::configure($table);
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
            'index' => ListProduks::route('/'),
            'create' => CreateProduk::route('/create'),
            'edit' => EditProduk::route('/{record}/edit'),
        ];
    }
}
