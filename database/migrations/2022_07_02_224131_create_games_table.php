<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('name');
            $table->string('url');
            $table->string('store');
            $table->unsignedFloat('price');
            $table->unsignedInteger('order');
            $table->boolean('bought');
            $table->boolean('deleted');
            $table->boolean('auto');

            $table->unsignedBigInteger('wishlist_id');
            $table->foreign('wishlist_id')->references('id')->on('wishlists');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games');
    }
};
