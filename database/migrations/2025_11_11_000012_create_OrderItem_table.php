<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('OrderItem', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('Order_id');
            $table->unsignedBigInteger('Listing_id');
            $table->decimal('kaina', 10, 2);
            $table->integer('kiekis')->default(1);
            $table->timestamps();

            $table->foreign('Order_id')->references('id')->on('Order')->onDelete('cascade');
            $table->foreign('Listing_id')->references('id')->on('Listing')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('OrderItem');
    }
};

