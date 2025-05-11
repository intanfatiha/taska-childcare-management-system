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
        Schema::table('camera_footages', function (Blueprint $table) {
            
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->date('date')->nullable();
            $table->string('file_location')->nullable();
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('camera_footages', function (Blueprint $table) {
          
            $table->dropColumn(['start_time', 'end_time', 'date', 'file_location']);
        
        });
    }
};
