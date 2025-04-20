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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('bukti_dp')->nullable()->after('status');
            $table->string('bukti_lunas')->nullable()->after('bukti_dp');
            $table->string('bukti_dibawa')->nullable()->after('bukti_lunas');
            $table->string('bukti_kembali')->nullable()->after('bukti_dibawa');
            $table->enum('status', ['dipesan', 'DP', 'lunas', 'diproses', 'dibawa', 'dikembalikan', 'selesai', 'batal'])->default('dipesan')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('bukti_dp');
            $table->dropColumn('bukti_lunas');
            $table->dropColumn('bukti_dibawa');
            $table->dropColumn('bukti_kembali');
            $table->enum('status', ['dipesan', 'DP', 'diproses', 'dibawa', 'dikembalikan', 'selesai', 'batal'])->default('dipesan')->change();
        });
    }
};
