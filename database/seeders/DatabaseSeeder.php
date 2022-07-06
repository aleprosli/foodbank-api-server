<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\FoodbankSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([AdminSeeder::class]);
        $this->call([FoodbankSeeder::class]);
        $this->call([CategorySeeder::class]);
        $this->call([LevelSeeder::class]);
        $this->call([CrowdfundSeeder::class]);

    }
}
