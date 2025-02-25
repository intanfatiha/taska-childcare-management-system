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
        //field yang wajib diisi
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('photo')->nullable(); //ni boleh kosong takwajib //simpan nama file je dlm db. gmbr simpan dlm server
            $table->integer('capacity');
            $table->timestamps(); //default. bila data tu masuk
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};

//utk tengok dah run blom "php artisan migrate:status"