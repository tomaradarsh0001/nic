<?php

namespace Database\Seeders; // Ensure this namespace is correct

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class HolidaysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $holidays = [
            ['date' => '2025-01-26', 'description' => 'Republic Day'],
            ['date' => '2025-02-26', 'description' => 'Maha Shivaratri'],
            ['date' => '2025-03-14', 'description' => 'Holi'],
            ['date' => '2025-03-31', 'description' => 'Id-ul-Fitr'],
            ['date' => '2025-04-10', 'description' => 'Mahavir Jayanti'],
            ['date' => '2025-04-18', 'description' => 'Good Friday'],
            ['date' => '2025-05-12', 'description' => 'Buddha Purnima'],
            ['date' => '2025-06-07', 'description' => 'Id-ul-Zuha (Bakrid)'],
            ['date' => '2025-07-06', 'description' => 'Muharram'],
            ['date' => '2025-08-15', 'description' => 'Independence Day'],
            ['date' => '2025-08-16', 'description' => 'Janmashtami'],
            ['date' => '2025-09-05', 'description' => 'Milad-un-Nabi or Id-e-Milad'],
            ['date' => '2025-10-02', 'description' => 'Mahatma Gandhi Jayanti'],
            ['date' => '2025-10-02', 'description' => 'Dussehra'],
            ['date' => '2025-10-20', 'description' => 'Diwali (Deepavali)'],
            ['date' => '2025-11-05', 'description' => 'Guru Nanak’s Birthday'],
            ['date' => '2025-12-25', 'description' => 'Christmas Day'],
        ];

        foreach ($holidays as &$holiday) {
            $holiday['created_at'] = Carbon::now();
            $holiday['updated_at'] = Carbon::now();
        }

        DB::table('holidays')->insert($holidays);
    }
}
