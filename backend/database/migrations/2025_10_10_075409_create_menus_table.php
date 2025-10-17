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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('number');
            $table->integer('price');
            $table->text('image_path');
            $table->string('description');
            $table->float('sweetness');
            $table->float('sourness');
            $table->float('saltiness');
            $table->float('bitterness');
            $table->float('umami');
            $table->float('spiciness');
            $table->float('astringency');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
