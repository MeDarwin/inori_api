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
        Schema::create('visitor_count', function (Blueprint $table) {
            $table->id();
            $table->timestamp('viewed_at')->useCurrent();
            $table->string('view_url', 100);
            $table->enum('view_type', ['homepage', 'magazine', 'admin', 'login', 'register']);
            $table->timestamp('visitor')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitor_count');
    }
};
