<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('City', function (Blueprint $table) {
            $table->id();
            $table->string('pavadinimas', 100);
            $table->unsignedBigInteger('Country_id')->nullable();
            $table->timestamps();

            $table->foreign('Country_id')->references('id')->on('Country')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('City');
    }
};

