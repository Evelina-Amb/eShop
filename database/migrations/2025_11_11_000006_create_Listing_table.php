<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('Listing', function (Blueprint $table) {
            $table->id();
            $table->string('pavadinimas', 100);
            $table->text('aprasymas');
            $table->decimal('kaina', 10, 2);
            $table->string('tipas', 20);
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('Category_id');
            $table->string('statusas', 30)->default('aktyvus');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('Category_id')->references('id')->on('Category')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Listing');
    }
};
