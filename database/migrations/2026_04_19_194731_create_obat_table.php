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
        Schema::create('obat', function (Blueprint $table) {
            $table->id();
            $table->string('kode_obat', 50)->unique();
            $table->string('nama_obat', 150);
            $table->string('kategori', 100)->nullable();
            $table->string('satuan', 50)->nullable();
            $table->decimal('harga_beli', 10, 2)->default(0);
            $table->decimal('harga_jual', 10, 2)->default(0);
            $table->integer('stok')->default(0);
            $table->date('expired')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obat');
    }
};
