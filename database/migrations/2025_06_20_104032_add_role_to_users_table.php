<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Cek apakah kolom 'role' sudah ada
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role', 10)->default('user')->after('password');
            } else {
                // Pastikan panjang kolom cukup dan default-nya sesuai
                $table->string('role', 10)->default('user')->change();
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
        });
    }
};
