<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('doctor_id', 10)->unique(); // DOC001, DOC002, etc
            $table->string('name');
            $table->string('specialty');
            $table->integer('consultation_fee');
            $table->integer('experience_years')->default(0);
            $table->text('description')->nullable();
            $table->json('skills')->nullable();
            $table->string('color', 20)->default('blue');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index('doctor_id');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};