<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateOldColoniesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Data for the `new_name` column
        $newNameData = [
            // ['id' => 16, 'new_name' => strtoupper('APJ Abdul Kalam Marg')],
            // ['id' => 15, 'new_name' => strtoupper('APJ Abdul Kalam Lane')],
            // ['id' => 42, 'new_name' => strtoupper('Bangla Sahib Marg')],
            // ['id' => 69, 'new_name' => strtoupper('KG Marg')],
            // ['id' => 186, 'new_name' => strtoupper('Shaheed Bhagat Singh Marg')],
            // ['id' => 225, 'new_name' => strtoupper('Rani Jhansi Marg')],
            // ['id' => 356, 'new_name' => strtoupper('Rajesh Pilot Marg')],
            // ['id' => 355, 'new_name' => strtoupper('Rajesh Pilot Lane')],
            // ['id' => 153, 'new_name' => strtoupper('Tolstoy Road')],
            // ['id' => 430, 'new_name' => strtoupper('Motilal Nehru Marg')],
            // ['id' => 21, 'new_name' => strtoupper('Amrita Shergil Marg')], // New entry for id 21
            // ['id'=> 215, 'new_name'=> strtoupper('Mahatma Gandhi Road')],
            // ['id'=> 417, 'new_name'=> strtoupper("Vasant Vihar")],
            // ['id'=> 6, 'new_name'=> strtoupper('B K Dutt')]
            ['id'=> 417, 'new_name'=> NULL],


        ];

        foreach ($newNameData as $row) {
            DB::table('old_colonies')->where('id', $row['id'])->update(['new_name' => $row['new_name']]);
        }

        // Data for the `name` column
        $nameData = [
            // ['id' => 103, 'name' => strtoupper('Gole Market')],
            // ['id' => 367, 'name' => strtoupper('Tughlak Lane')],
            // ['id' => 368, 'name' => strtoupper('Tughlak Road')],
            // ['id' => 21, 'name' => strtoupper('Ratendon Road')], // New entry for id 21
            // ['id'=> 158, 'name' => strtoupper('Kidwai Nagar')],
            // ['id'=> 240, 'name' => strtoupper("Mathura Road")],
            // ['id'=> 287, 'name' => strtoupper('Pushp Vihar')],
            // ['id'=> 330, 'name' => strtoupper('SHAHJAHAN ROAD')],
            // ['id'=> 242, 'name' => strtoupper('Motia Khan')],
            // ['id'=> 204, 'name' => strtoupper('Malka Ganj D-Q')],
            // ['id'=> 246, 'name' => strtoupper('Narela')],
            // ['id'=> 349, 'name' => strtoupper('Sardar Patel Marg')],
            ['id'=> 417, 'name'=> strtoupper("Vasant Vihar")],
            ['id'=> 241, 'name'=> strtoupper("Moti Bagh")],
        ];

        foreach ($nameData as $row) {
            DB::table('old_colonies')->where('id', $row['id'])->update(['name' => $row['name']]);
        }
    }
}
