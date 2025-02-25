<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //panggil n run room factory utk create 15 data fake
        Room::factory()->count(15)->create(); // utk run  php artisan db:seed --class=RoomSeeder
    }
}
