<?php

namespace App\Filament\Resources\Orders;

use App\Filament\Resources\Orders\Pages\CreateOrder;
use App\Filament\Resources\Orders\Pages\EditOrder;
use App\Filament\Resources\Orders\Pages\ListOrders;
use App\Filament\Resources\Orders\Schemas\OrderForm;
use App\Filament\Resources\Orders\Tables\OrdersTable;
use App\Models\Order;
use App\Models\Produk;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Forms\Components\Repeater;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static ?string $maxContentWidth = 'full';
    protected function afterCreate(): void
    {
        $items=$this->record->order_items ?? [];
        foreach($items as $item){
            $produk=Produk::find($item['product_id']);
            if($produk){
                $produk->decrement('stok', (int) $item['quantity']);
            }
        }
    }
    
  protected static function updateTotal(callable $set, callable $get): void
{
    $items = $get('../../order_items') ?? [];

    $total = collect($items)->sum(function ($item) {

        $price = isset($item['price']) 
            ? (int) filter_var($item['price'], FILTER_SANITIZE_NUMBER_INT) 
            : 0;

        $qty = isset($item['quantity']) 
            ? (int) $item['quantity'] 
            : 0;

        return $qty * $price;
    });

    $set('../../total', $total);
}
    

    public static function form(Schema $schema): Schema
    {
        return $schema
        ->columns(1)
        ->components([
            Wizard::make([
                Step::make('Order Details')
                    ->columns(2)
                    ->schema([
                        TextInput::make('kode_pesanan')
                            ->label('Kode Pesanan')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->default(function () {
                                $today = now()->format('Ymd');

                                $lastOrder = Order::whereDate('created_at', today())
                                    ->latest()
                                    ->first();

                                $number = 1;

                                if ($lastOrder) {
                                    $lastNumber = (int) substr($lastOrder->kode_pesanan, -3);
                                    $number = $lastNumber + 1;
                                }

                                return 'ORD-' . $today . '-' . str_pad($number, 3, '0', STR_PAD_LEFT);
                            })
                            ->disabled() // biar tidak bisa diedit user
                            ->dehydrated(), // tetap dikirim ke database,
                        Select::make('customer_id')
                            ->label('Customer')
                            ->relationship('customer', 'nama_customer')
                            ->required()
                            ->preload()
                            ->createOptionForm([
                                TextInput::make('nama_customer')
                                    ->label('Nama Customer')
                                    ->required(),
                                TextInput::make('alamat')
                                    ->label('Alamat')
                                    ->required(),
                                TextInput::make('telepon')
                                    ->label('Telepon')
                                    ->required(),
                            ]),
                        DatePicker::make('tanggal_pesanan')
                            ->label('Tanggal Pesanan')
                            ->required(),
                    ]),
                Step::make('Order Items')
                
                    ->schema([
             Repeater::make('order_items') // ✅ FIX: konsisten
    ->schema([

        Select::make('product_id')
            ->label('Produk')
            ->options(\App\Models\Produk::pluck('nama_produk', 'id'))
            ->required()
            ->searchable()
            ->reactive()
            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                $product = \App\Models\Produk::find($state);

                if ($product) {
                    $set('price', $product->harga_jual);
                    $set('subtotal', ($get('quantity') ?? 0) * $product->harga_jual);
                }

                self::updateTotal($set, $get);
            }),

        TextInput::make('quantity')
            ->label('Qty')
            ->numeric()
            ->required()
            ->default(1)
            ->reactive()
            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                $set('subtotal', ($state ?? 0) * ($get('price') ?? 0));
                self::updateTotal($set, $get);
            }),

        TextInput::make('price')
            ->label('Harga')
            ->numeric()
            ->disabled(),

        TextInput::make('subtotal')
            ->label('Subtotal')
            ->numeric()
            ->disabled()
            ->reactive(),

    ])
    ->columns(4)
    ->defaultItems(1)
    ->addActionLabel('Tambah Produk'),

TextInput::make('total')
    ->label('Total')
    ->numeric()
    ->disabled()
    ->dehydrated(),      
               ]),   
    
            ])
            ->submitAction(
    \Filament\Actions\Action::make('save')
        ->label('Simpan Pesanan')
        ->submit('create'))
        ]);

                    


    }

    public static function table(Table $table): Table
    {
        return OrdersTable::configure($table);
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
            'index' => ListOrders::route('/'),
            'create' => CreateOrder::route('/create'),
            'edit' => EditOrder::route('/{record}/edit'),
        ];
    }
}
