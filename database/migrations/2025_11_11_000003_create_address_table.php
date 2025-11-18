<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('Address', function (Blueprint $table) {
            $table->id();
            $table->string('gatve', 100);
            $table->string('namo_nr', 10)->nullable();
            $table->string('buto_nr', 10)->nullable();
            $table->unsignedBigInteger('City_id')->nullable();
            $table->timestamps();

            $table->foreign('City_id')->references('id')->on('City')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Address');
    }
};

