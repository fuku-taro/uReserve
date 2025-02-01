<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Reservation;

class ReservationSeeder extends Seeder
{
        public function run(): void
        {
        Reservation::create([
                'user_id' => 1,
                'event_id' => 1,
                'number_of_people' => 5,
        ]);
        Reservation::create([
                'user_id' => 2,
                'event_id' => 1,
                'number_of_people' => 3,
        ]);
        Reservation::create([
                'user_id' => 1,
                'event_id' => 2,
                'number_of_people' => 2,
        ]);
        Reservation::create([
                'user_id' => 2,
                'event_id' => 2,
                'number_of_people' => 2,
                'canceled_date' => '2025-02-01 00:00:00',
        ]);
}
}
