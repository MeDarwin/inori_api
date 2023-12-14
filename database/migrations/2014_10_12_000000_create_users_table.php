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
            $table->string('nis_nip',20)->unique()->nullable();
            $table->string('nisn',12)->unique()->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['member', 'admin', 'club_leader', 'osis', 'club_mentor'])->default('member');
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
