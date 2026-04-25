<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Customer;
use App\Models\Orderitem;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'kode_pesanan',
        'customer_id',
        'tanggal_pesanan',
        'total',
        'order_items', // ✅ FIX NAMA
    ];
    protected $casts = [
    'order_items' => 'array',
];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

}
