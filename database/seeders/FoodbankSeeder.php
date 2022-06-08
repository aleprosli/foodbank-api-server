<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FoodbankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('foodbanks')->insert([
            [
                'id' => 1,
                'title' => 'Ayam',
                'description' => 'Bahan Basah',
                'location' => 'Klang',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'id' => 2,
                'title' => 'Ikan',
                'description' => 'Bahan Basah',
                'location' => 'Shah Alam',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'id' => 3,
                'title' => 'Daging',
                'description' => 'Bahan Basah',
                'location' => 'Damansara',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'id' => 4,
                'title' => 'Meggi',
                'description' => 'Bahan Masak',
                'location' => 'USJ',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'id' => 5,
                'title' => 'Sotong',
                'description' => 'Bahan Basah',
                'location' => 'Puchong',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'id' => 6,
                'title' => 'Udang',
                'description' => 'Bahan Basah',
                'location' => 'Cyberjaya',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'id' => 7,
                'title' => 'Sayur',
                'description' => 'Bahan Basah',
                'location' => 'Seri Kembangan',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'id' => 8,
                'title' => 'Ketam',
                'description' => 'Bahan Basah',
                'location' => 'Putrajaya',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'id' => 9,
                'title' => 'Bihun',
                'description' => 'Bahan Masak',
                'location' => 'Bangi',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'id' => 10,
                'title' => 'Beras',
                'description' => 'Bahan Masak',
                'location' => 'Kuala Selangor',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            ]);
    }
}
