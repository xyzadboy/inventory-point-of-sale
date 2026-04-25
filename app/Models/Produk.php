<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Kategori;
use App\Models\Satuan;
use App\Models\Supplier;
use App\Models\Orderitem;

class Produk extends Model
{
    protected $table = 'produk';

    protected $fillable = [
        'nama_produk',
        'kategori_id',
        'satuan_id',
        'sku',
        'supplier_id',
        'harga_beli',
        'harga_jual',
        'stok',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function satuan()
    {
        return $this->belongsTo(Satuan::class, 'satuan_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
    public function orderItems()
    {
        return $this->hasMany(Orderitem::class, 'product_id');
    }
}
