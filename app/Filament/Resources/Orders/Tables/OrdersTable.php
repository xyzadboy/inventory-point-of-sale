<?php

namespace App\Filament\Resources\Orders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\MultiSelectFilter;
use Filament\Tables\Filters\DateFilter;
use Filament\Tables\Filters\DateTimeFilter;
use Filament\Tables\Filters\TimeFilter;
// use Filament\Tables\Actions\Action;
use Filament\Actions\Action;
use Models\Customer;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->poll('3s')
            ->columns([
                TextColumn::make('kode_pesanan')->label('ID'),
                TextColumn::make('Customer.nama_customer')
                ->label('Customer')
                ->sortable()
                ->searchable(),
                TextColumn::make('tanggal_pesanan')->label('Tanggal Pesanan')->date()->sortable(),
                // TextColumn::make('total_harga')->label('Total Harga')->money('idr', true)->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                
            ])
            ->Actions([
                Action::make('print')
                ->label('Print')
                ->icon('heroicon-o-printer')
                ->url(fn ($record) => route('orders.print', ['id' => $record->id]))
                ->openUrlInNewTab()
                ,
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
