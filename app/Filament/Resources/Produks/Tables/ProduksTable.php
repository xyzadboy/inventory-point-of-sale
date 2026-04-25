<?php

namespace App\Filament\Resources\Produks\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class ProduksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->poll('3s')
            ->columns([
                TextColumn::make('nama_produk')->label('Nama Produk')->searchable()->sortable(),
                TextColumn::make('harga_jual')->label('Harga Jual')->money('IDR', true)->sortable(),
                TextColumn::make('harga_beli')->label('Harga Beli')->money('IDR', true)->sortable(),
                TextColumn::make('stok')->label('Stok')->sortable(),
                TextColumn::make('kategori.nama_kategori')->label('Kategori')->searchable()->sortable(),
                TextColumn::make('satuan.nama_satuan')->label('Satuan')->searchable()->sortable(),
                TextColumn::make('supplier.nama_supplier')->label('Supplier')->searchable()->sortable(),
                TextColumn::make('sku')->label('SKU')->searchable()->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()
                ->visible(fn () => auth()->user()?->can('edit produk')),
                DeleteAction::make()
                ->visible(fn () => auth()->user()?->can('delete produk')),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
