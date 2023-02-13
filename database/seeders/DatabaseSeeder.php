<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

         \App\Models\User::factory()->create([
             'name' => 'Test User',
             'email' => 'test@user.com',
             'password' => Hash::make('1'),
             'type' => 0
         ])

         ;\App\Models\User::factory()->create([
             'name' => 'Test Admin',
             'email' => 'test@admin.com',
             'password' => Hash::make('1'),
             'type' => 1
         ])

        ;\App\Models\User::factory()->create([
             'name' => 'Test Manager',
             'email' => 'test@manager.com',
             'password' => Hash::make('1'),
             'type' => 2
         ]);
    }
}
