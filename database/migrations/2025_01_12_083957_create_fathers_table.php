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
        Schema::create('fathers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id');
            $table->foreign('parent_id')->references('id')->on('parent_infos')->onDelete('cascade');
            $table->string('father_name');
            $table->string('father_email')->unique();
            $table->string('father_phoneNo');
            $table->string('father_ic')->unique();
            $table->string('father_address');
            $table->string('father_nationality');
            $table->string('father_race');
            $table->string('father_religion');
            $table->string('father_occupation');
            $table->decimal('father_monthly_income', 10, 2);
            $table->string('father_staff_number')->nullable();
            $table->string('father_ptj')->nullable();
            $table->string('father_office_number')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fathers');
    }
};
