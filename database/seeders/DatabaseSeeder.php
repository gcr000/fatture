<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\Customer::factory(50)->create();

        \App\Models\User::create([
            'name' => 'Giancarlo Uzzo',
            'email' => 'gcr000@gmail.com',
            'password' => '$2y$12$0.wSVDpefUCNzZwF4nQ1QOrdjBxRvlzcF7/eGrWURRQLUQ50VjMhi',
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
