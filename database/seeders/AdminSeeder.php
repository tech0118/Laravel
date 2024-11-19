<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'=>'admin',
            'email'=>'admin@gmail.com',
            'password'=>Hash::make('admin@123'),
            'role_id'=>1
        ]);
        User::create([
            'name'=>'yash',
            'email'=>'yash@gmail.com',
            'password'=>Hash::make('1234'),
            'role_id'=>2
        ]);
        User::create([
            'name'=>'manav',
            'email'=>'manav@gmail.com',
            'password'=>Hash::make('1234'),
            'role_id'=>2
        ]);
        User::create([
            'name'=>'vraj',
            'email'=>'vraj@gmail.com',
            'password'=>Hash::make('1234'),
            'role_id'=>2
        ]);
        User::create([
            'name'=>'pratik',
            'email'=>'pratik@gmail.com',
            'password'=>Hash::make('1234'),
            'role_id'=>2
        ]);
        User::create([
            'name'=>'vishal',
            'email'=>'vishal@gmail.com',
            'password'=>Hash::make('1234'),
            'role_id'=>2
        ]);
    }
}
