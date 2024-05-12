<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('computer_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('computer_id')->nullable()->constrained();
            $table->string('ip_address')->nullable();
            $table->string('report');
            $table->enum('status', ['checked', 'pending'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('computer_status_logs');
    }
};
