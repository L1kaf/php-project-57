<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TaskStatus;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        TaskStatus::create(['name' => 'новый']);
        TaskStatus::create(['name' => 'в работе']);
        TaskStatus::create(['name' => 'на тестировании']);
        TaskStatus::create(['name' => 'завершен']);
    }
}
