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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('thumb_url')->nullable();
            $table->text('description')->nullable();
            $table->integer('qty')->default(0);
            $table->integer('good_qty')->default(0);
            $table->integer('bad_qty')->default(0);
            $table->integer('rent_qty')->default(0);
            $table->integer('base_price')->default(0);
            $table->integer('price')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
