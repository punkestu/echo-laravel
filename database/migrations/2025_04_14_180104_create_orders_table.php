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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('nama');
            $table->string('no_telp');
            $table->string('alamat', 255);
            $table->enum('jaminan', ['KTP', 'SIM']);
            $table->enum('pengambilan', ['Ambil di Rumah', 'COD']);
            $table->string('tempat_cod', 255)->nullable();
            $table->dateTime('jam_ambil');
            $table->dateTime('jam_kembali');
            $table->enum('status', ['dipesan', 'DP', 'diproses', 'dibawa', 'dikembalikan', 'selesai', 'batal'])->default('dipesan');
            $table->integer('price')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
