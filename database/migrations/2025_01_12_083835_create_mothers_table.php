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
        Schema::create('mothers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id');
            $table->foreign('parent_id')->references('id')->on('parent_infos')->onDelete('cascade');
            $table->string('mother_name');
            $table->string('mother_email')->unique();
            $table->string('mother_phoneNo');
            $table->string('mother_ic')->unique();
            $table->string('mother_address');
            $table->string('mother_nationality');
            $table->string('mother_race');
            $table->string('mother_religion');
            $table->string('mother_occupation');
            $table->decimal('mother_monthly_income', 10, 2);
            $table->string('mother_staff_number')->nullable();
            $table->string('mother_ptj')->nullable();
            $table->string('mother_office_number')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mothers');
    }
};
