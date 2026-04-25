<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('penjualan', function (Blueprint $table) {
            // Cek di phpMyAdmin, jika kolom ini belum ada, tambahkan:
            if (!Schema::hasColumn('penjualan', 'no_faktur')) {
                $table->string('no_faktur')->after('id');
            }
            if (!Schema::hasColumn('penjualan', 'total_harga')) {
                $table->integer('total_harga')->after('tanggal');
            }
            if (!Schema::hasColumn('penjualan', 'bayar')) {
                $table->integer('bayar')->after('total_harga');
            }
            if (!Schema::hasColumn('penjualan', 'kembalian')) {
                $table->integer('kembalian')->after('bayar');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penjualan', function (Blueprint $table) {
            //
        });
    }
};
