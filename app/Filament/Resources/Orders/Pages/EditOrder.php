<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use App\Models\Produk;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;
    
    protected function beforeSave(): void
    {
        // 🔁 KEMBALIKAN STOK LAMA
        $oldItems = $this->record->getOriginal('order_items') ?? [];

        foreach ($oldItems as $item) {

            $produk = Produk::find($item['product_id']);

            if ($produk) {
                $produk->increment('stok', (int) $item['quantity']);
            }
        }
    }

    protected function afterSave(): void
    {
        // 🔻 KURANGI STOK BARU
        $newItems = $this->record->order_items ?? [];

        foreach ($newItems as $item) {

            $produk = Produk::find($item['product_id']);

            if ($produk) {
                $produk->decrement('stok', (int) $item['quantity']);
            }
        }
    }

    // 🔥 FIX: normalisasi data saat edit dibuka
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['order_items'] = collect($data['order_items'] ?? [])->map(function ($item) {

            $product = Produk::find($item['product_id'] ?? null);

            $price = $product?->harga_jual ?? (int) ($item['price'] ?? 0);
            $qty   = (int) ($item['quantity'] ?? 1);

            return [
                'product_id' => $item['product_id'] ?? null,
                'nama_produk'  => $product?->nama_produk ?? $item['nama_produk'] ?? null, // ✅ tambahkan ini
                'quantity'   => $qty,
                'price'      => (int) $price,
                'subtotal'   => $qty * (int) $price,
            ];
        })->toArray();

        return $data;
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([

                // ======================
                // ORDER DETAIL
                // ======================
                Section::make('Order Details')
                    ->columns(2)
                    ->schema([
                        TextInput::make('kode_pesanan')
                            ->disabled(),

                        Select::make('customer_id')
                            ->relationship('customer', 'nama_customer')
                            ->required(),

                        DatePicker::make('tanggal_pesanan')
                            ->required(),
                    ]),

                // ======================
                // ORDER ITEMS
                // ======================
                Section::make('Order Items')
                    ->schema([

                        Repeater::make('order_items')
                            ->schema([

                                Select::make('product_id')
                                    ->label('Produk')
                                    ->options(Produk::pluck('nama_produk', 'id'))
                                    ->searchable()
                                    ->reactive()
                                    ->afterStateHydrated(function ($state, callable $set) {
                                        $product = Produk::find($state);

                                        if ($product) {
                                            $set('price', (int) $product->harga_jual);
                                        }
                                    })
                                    ->afterStateUpdated(function ($state, callable $set, callable $get) {

                                        $product = Produk::find($state);

                                        if ($product) {
                                            $price = (int) $product->harga_jual;
                                            $qty   = (int) ($get('quantity') ?? 1);

                                            $set('price', $price);
                                            $set('subtotal', $qty * $price);
                                        }

                                        self::updateTotal($set, $get);
                                    }),

                                TextInput::make('quantity')
                                    ->numeric()
                                    ->default(1)
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, callable $set, callable $get) {

                                        $price = (int) ($get('price') ?? 0);

                                        $set('subtotal', (int) $state * $price);

                                        self::updateTotal($set, $get);
                                    }),

                                TextInput::make('price')
                                    ->disabled()
                                    ->dehydrated()
                                    ->numeric(),

                                TextInput::make('subtotal')
                                    ->disabled()
                                    ->dehydrated()
                                    ->numeric(),
                            ])
                            ->columns(2),

                        // ======================
                        // TOTAL
                        // ======================
                        TextInput::make('total')
                            ->label('Total')
                            ->disabled()
                            ->dehydrated()
                            ->numeric(),
                    ]),
            ]);
    }

    // ======================
    // HITUNG TOTAL
    // ======================
    protected static function updateTotal(callable $set, callable $get): void
    {
        $items = $get('../../order_items') ?? [];

        $total = collect($items)->sum(function ($item) {

            $price = (int) ($item['price'] ?? 0);
            $qty   = (int) ($item['quantity'] ?? 0);

            return $price * $qty;
        });

        $set('../../total', $total);
    }
}