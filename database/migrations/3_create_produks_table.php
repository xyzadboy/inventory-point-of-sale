<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->id();
            $table->string('nama_produk');
            $table->string('sku')->unique();
            $table->foreignId('kategori_id')->constrained('kategori')->onDelete('NO ACTION');
            $table->foreignId('satuan_id')->constrained('satuan')->onDelete('NO ACTION');
            $table->foreignId('supplier_id')->constrained('supplier')->onDelete('NO ACTION');
            $table->decimal('harga_beli', 15, 2);
            $table->decimal('harga_jual', 15, 2);
            $table->integer('stok');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
