<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Produk;
use Illuminate\Support\Facades\DB;


class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;

    protected function afterCreate(): void
{
    DB::transaction(function () {

        $items = $this->record->order_items ?? [];

        foreach ($items as $item) {

            if (empty($item['product_id'])) {
                continue;
            }

            $produk = Produk::find($item['product_id']);

            if (!$produk) {
                continue;
            }

            $qty = (int) ($item['quantity'] ?? 0);

            // 🔥 VALIDASI STOK
            if ($produk->stok < $qty) {
                throw new \Exception("Stok {$produk->nama_produk} tidak cukup");
            }

            // 🔻 KURANGI STOK
            $produk->decrement('stok', $qty);
        }
    });
}

    protected function mutateFormDataBeforeCreate(array $data): array
{
    $items = collect($data['order_items'] ?? [])->map(function ($item) {

        $produk = Produk::find($item['product_id']);

        return [
            'product_id'  => $produk->id,
            'nama_produk' => $produk->nama_produk,
            'price'       => $produk->harga_jual,
            'quantity'    => $item['quantity'],
            'subtotal'    => $produk->harga_jual * $item['quantity'],
        ];
    });

    $data['order_items'] = $items->toArray();

    $data['total'] = $items->sum('subtotal');

    return $data;
}
    
    protected function getFormActions(): array
{
    return [];
}
}
