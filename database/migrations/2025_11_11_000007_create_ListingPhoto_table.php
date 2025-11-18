<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ListingPhoto', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('Listing_id');
            $table->string('failo_url', 255);
            $table->timestamps();

            $table->foreign('Listing_id')->references('id')->on('Listing')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ListingPhoto');
    }
};

