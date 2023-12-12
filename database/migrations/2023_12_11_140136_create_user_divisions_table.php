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
        Schema::create('user_division', function (Blueprint $table) {
            $table->id();
            $table->string('username', 30)->index();
            $table->string('division_name', 50)->index();

            $table->foreign('username')->references('username')->on('user')
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('division_name')->references('name')->on('division')
                ->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_division');
    }
};
