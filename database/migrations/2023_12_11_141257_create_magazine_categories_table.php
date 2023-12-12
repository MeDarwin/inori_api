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
        Schema::create('magazine_category', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('magazine_id')->index();
            $table->string('category_name', 50)->index();
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('magazine_id')->references('id')->on('magazine')
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('category_name')->references('name')->on('category')
                ->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('magazine_category');
    }
};
