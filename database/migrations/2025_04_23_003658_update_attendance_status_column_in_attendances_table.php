<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Update the attendance time in & out to nullable in the attendances table.
     */
   public function up(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->time('time_in')->nullable();
            $table->time('time_out')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn(['time_in', 'time_out']);
        });
    }

};
