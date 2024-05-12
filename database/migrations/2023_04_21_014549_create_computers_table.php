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
        Schema::create('computers', function (Blueprint $table) {
            $table->id();
            $table->string('computer_number');
            $table->string('computer_name');
            $table->string('os');
            $table->string('processor');
            $table->string('memory');
            $table->string('storage');
            $table->string('graphics');
            $table->string('ip_address')->nullable();
            $table->enum('status', ['active','occupied', 'offline', 'under_maintenance'])->default('offline');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('computers');
    }
};
