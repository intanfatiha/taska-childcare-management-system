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
              // Add user_id column after id
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade')->after('id');

            // Move timestamps to the end of the table
            $table->dropTimestamps(); 
            $table->timestamps();    
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('camera_footages', function (Blueprint $table) {
               // Drop the user_id column
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');

            $table->dropTimestamps();
            $table->timestamps();
        
        });
    }
};
