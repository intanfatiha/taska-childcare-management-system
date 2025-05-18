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
        Schema::table('parent_records', function (Blueprint $table) {
            $table->foreignId('father_id')->nullable()->change();
            $table->foreignId('mother_id')->nullable()->change();
            $table->foreignId('guardian_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('parent_records', function (Blueprint $table) {
            $table->foreignId('father_id')->nullable(false)->change();
            $table->foreignId('mother_id')->nullable(false)->change();
            $table->foreignId('guardian_id')->nullable(false)->change();
        });
    }
};
