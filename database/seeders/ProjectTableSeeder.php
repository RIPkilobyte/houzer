<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectTableSeeder extends Seeder
{
    public function run()
    {
        $project1 = [
            'number' => 'no1',
            'name' => 'name1',
            'description' => 'descr1',
            'link' => 'link1',
            'active' => 1,
        ];
        DB::table('projects')->insert($project1);
        $project2 = [
            'number' => 'no2',
            'name' => 'name2',
            'description' => 'descr2',
            'link' => 'link2',
            'active' => 0,
        ];
        DB::table('projects')->insert($project2);
    }
}
