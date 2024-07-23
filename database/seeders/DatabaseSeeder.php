<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Concerns\UserTypes;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        User::create([
            'email' => 'support@emergencymarket.com',
            'password' => Hash::make('Cl@rity2022'),
            'type' => UserTypes::ADMIN->value,
            'status' => true,
        ]);

        $this->call([
            StateSeeder::class,
            CitySeeder::class,
            ResourcesSeeder::class,
        ]);

        DB::unprepared(file_get_contents(base_path('database/seeders/sql/users.sql')));
        DB::unprepared(file_get_contents(base_path('database/seeders/sql/provider_profiles.sql')));
        DB::unprepared(file_get_contents(base_path('database/seeders/sql/companies.sql')));
    }
}
