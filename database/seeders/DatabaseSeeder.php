<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

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
        DB::table('users')->insert([
            [
                'name' => 'Maksymilian Gintner',
                'email' => 'maks@wp.pl',
                'password' => bcrypt('Haslo123'),

            ],


        ]);
    }

}
