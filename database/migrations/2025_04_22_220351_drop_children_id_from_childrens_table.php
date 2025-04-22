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
        Schema::table('childrens', function (Blueprint $table) {
            //
            $table->dropColumn('children_id');
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('childrens', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('children_id')->nullable(); // Recreate the column if rolled back

        });
    }
};
