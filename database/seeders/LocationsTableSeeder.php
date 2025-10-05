<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $properties = [
            ['name' => 'South East England', 'created_at' => now(), 'updated_at' => now(),],
            ['name' => 'South West England', 'created_at' => now(), 'updated_at' => now(),],
            ['name' => 'East of England', 'created_at' => now(), 'updated_at' => now(),],
            ['name' => 'Yorkshire & The Humber', 'created_at' => now(), 'updated_at' => now(),],
            ['name' => 'West Midlands', 'created_at' => now(), 'updated_at' => now(),],
            ['name' => 'Scotland', 'created_at' => now(), 'updated_at' => now(),],
            ['name' => 'Greater London', 'created_at' => now(), 'updated_at' => now(),],
            ['name' => 'North East England', 'created_at' => now(), 'updated_at' => now(),],
            ['name' => 'North West England', 'created_at' => now(), 'updated_at' => now(),],
            ['name' => 'East Midlands', 'created_at' => now(), 'updated_at' => now(),],
            ['name' => 'Wales', 'created_at' => now(), 'updated_at' => now(),],
            ['name' => 'Northern Ireland', 'created_at' => now(), 'updated_at' => now(),],
        ];
        DB::table('locations')->insert($properties);
    }
}
