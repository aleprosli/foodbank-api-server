<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CrowdfundSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('crowdfunds')->insert([
            [
                'id' => 1,
                'user_id' => 1,
                'title' => 'Emergency Funds',
                'image' => 'Duit.jpg',
                'description' => 'For Emergency Funds',
                'category_id' => 4,
                'total_donation' => 0,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            ]);
    }
}
