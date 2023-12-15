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
        Schema::create('magazine', function (Blueprint $table) {
            $table->id();
            $table->string('creator_username', 30)->nullable()->index();
            $table->string('verified_by', 30)->nullable()->index();
            $table->boolean('is_verified')->default(false);
            $table->string('thumbnail', 100)->nullable();
            $table->string('title', 100);
            $table->text('body');
            $table->string('footer')->nullable();
            $table->timestamp('post_schedule')->useCurrent();
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('creator_username')->references('username')->on('user')
                ->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('verified_by')->references('username')->on('user')
                ->nullOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('magazine');
    }
};
