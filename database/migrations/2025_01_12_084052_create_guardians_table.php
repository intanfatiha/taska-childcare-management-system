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
        Schema::create('guardians', function (Blueprint $table) {
            $table->id();
            $table->string('guardian_name');
            $table->string('guardian_relation');
            $table->string('guardian_email')->unique();
            $table->string('guardian_phoneNo');
            $table->string('guardian_ic')->unique();
            $table->text('guardian_address');
            $table->string('guardian_nationality');
            $table->string('guardian_race');
            $table->string('guardian_religion');
            $table->string('guardian_occupation');
            $table->decimal('guardian_monthly_income', 10, 2);
            $table->string('guardian_staff_number')->nullable();
            $table->string('guardian_ptj')->nullable();
            $table->string('guardian_office_number')->nullable();
            $table->timestamps();
        });
    }
    
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guardians');
    }
};
