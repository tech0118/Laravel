<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Task::create([
            'title' => "task1",
            'description' => "Nothing",
            'deadline' => now()->addDays(10)
        ]);
        Task::create([
            'title' => "task2",
            'description' => "Nothing",
            'deadline' => now()->addDays(20)
        ]);
        Task::create([
            'title' => "task3",
            'description' => "Nothing",
            'deadline' => now()->addDays(2)
        ]);
        Task::create([
            'title' => "task4",
            'description' => "Nothing",
            'deadline' => now()->addDays(30)
        ]);
    }
}
