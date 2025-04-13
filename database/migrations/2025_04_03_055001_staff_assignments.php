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
        Schema::create('staff_assigments', function (Blueprint $table)
        {
            $table->id();
            $table->foreignId('child_id')->constrained('childrens')->onDelete('cascade');
            $table->foreignId('primary_staff_id')->constrained('staff')->onDelete('cascade');
            

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_assigments');
    }
};
