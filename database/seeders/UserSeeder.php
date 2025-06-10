<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminPertama = User::create([
            'first_name' => 'Admin',
            'last_name' => 'Pertama',
            'email' => 'admin@mail.com',
            'birth_date' => '2000-01-01',
            'gender' => 'male',
            'password' => bcrypt('password'),
        ]);

        $adminKedua = User::create([
            'first_name' => 'Admin',
            'last_name' => 'Kedua',
            'email' => 'admin2@mail.com',
            'birth_date' => '2000-01-02',
            'gender' => 'female',
            'password' => bcrypt('password'),
        ]);


    }
}
