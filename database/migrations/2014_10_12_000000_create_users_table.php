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
        Schema::create('user', function (Blueprint $table) {
            $table->string('username', 30)->primary();
            $table->string('email')->unique();
            $table->string('nis_nip')->unique()->nullable();
            $table->string('password');
            $table->enum('role', ['member', 'admin', 'club_leader', 'osis', 'club_mentor']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user');
    }
};
