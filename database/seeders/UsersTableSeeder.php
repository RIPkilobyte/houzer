<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $step_register = ['one', 'two', 'done'];
        $home_type = ['House', 'Apartments'];
        $admin = [
                'id'             => 1100,
                'email'          => 'admin@admin.com',
                'role'           => 'Admin',
                'first_name'     => 'Admin',
                'last_name'      => '',
                'phone'          => '123456798',
                'attention'      => 0,
                'step_register'  => 'done',
                'password'       => Hash::make('password'),
                'remember_token' => Str::random(60),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        DB::table('users')->insert($admin);
        $users = [
            [
                'email'          => 'user@admin.com',
                'role'           => 'User',
                'first_name'     => 'Last',
                'last_name'      => 'Name',
                'phone'          => '456789123',
                'attention'      => 0,
                'step_register'  => 'done',
                'house'          => 1,
                'apartments'     => 1,
                'homeowner'      => 1,
                'bedrooms1'      => 1,
                'bedrooms2'      => 0,
                'bedrooms3'      => 0,
                'bedrooms4'      => 1,
                'project'        => 0,
                'password'       => Hash::make('password'),
                'remember_token' => Str::random(60),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        DB::table('users')->insert($users);
//        $users = [];
//        $now_or_null = [now(), null];
//        for($i=0; $i<50; $i++) {
//            $users[$i] = [
//                'email' => 'user'.$i.'@gmail.com',
//                'role' => 'User',
//                'first_name' => 'user'.$i,
//                'last_name' => Str::random(8),
//                'phone' => Str::random(9),
//                'attention'      => 0,
//                'step_register'  => $step_register[rand(0,2)],
//                'home_type'      => $home_type[rand(0,1)],
//                'homeowner'      => rand(0,1),
//                'bedrooms1'      => rand(0,1),
//                'bedrooms2'      => rand(0,1),
//                'bedrooms3'      => rand(0,1),
//                'bedrooms4'      => rand(0,1),
//                'password' => Hash::make('password'),
//                'remember_token' => Str::random(60),
//                'email_verified_at' => $now_or_null[rand(0,1)],
//                'created_at' => now(),
//                'updated_at' => now(),
//            ];
//        }
//        DB::table('users')->insert($users);
    }
}
