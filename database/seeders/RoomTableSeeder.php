<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rooms = [
            ['name' => 'room one', 'description' => 'Room description one'],
            ['name' => 'room two', 'description' => 'Room description two'],
            ['name' => 'room three', 'description' => 'Room description three'],
        ];

        Room::insert($rooms);
    }
}
