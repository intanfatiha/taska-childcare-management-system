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
        Schema::create('childrens', function (Blueprint $table) {
            $table->id();
            $table->string('child_name');
            $table->date('child_birthdate');
            $table->enum('child_gender', ['Male', 'Female']);
            $table->integer('child_age');
            $table->string('child_address');
            $table->integer('child_sibling_number');
            $table->integer('child_numberInSibling');
            $table->string('child_allergies')->nullable();
            $table->string('child_medical_conditions')->nullable();
            $table->string('child_previous_childcare')->nullable();
            $table->string('child_birth_cert'); // photo
            $table->string('child_immunization_record'); // photo
            $table->string('child_photo'); // photo

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('childrens');
    }
};
