<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('favourite', function (Blueprint $table) {
            $table->id();
            $table->string('username', 30)->index();
            $table->unsignedBigInteger('magazine_id')->index();

            $table->foreign('username')->references('username')->on('user')
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('magazine_id')->references('id')->on('magazine')
                ->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favourite');
    }
};
