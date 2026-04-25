<?php

namespace App\Filament\Resources\Customers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Table;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;

class CustomersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->recordUrl(null)
            ->columns([
                TextColumn::make('nama_customer')->label('Nama Customer')->searchable()->sortable(),
                TextColumn::make('alamat')->label('Alamat')->searchable()->sortable(),
                TextColumn::make('telepon')->label('Telepon')->searchable()->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()
                ->visible(fn () => auth()->user()?->can('edit customer')),
                DeleteAction::make()
                ->visible(fn () => auth()->user()?->can('delete customer')),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
