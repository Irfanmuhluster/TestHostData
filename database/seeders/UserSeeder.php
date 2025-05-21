<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::create([
            'name' => 'Irfan',
            'email' => 'irfan@mail.com',
            'role' => 'admin',
            'password' => bcrypt('irfan123'),
        ]);

        User::create([
            'name' => 'Irfan Member',
            'email' => 'irfanmember@mail.com',
            'role' => 'member',
            'password' => bcrypt('member123'),
            'address' => 'Jl. Raya No. 1',
            'city' => 'Jakarta',
            'postal_code' => '10001',
            'firstName' => 'Irfan',
            'lastName' => 'Member',
            'phone' => '1234567890',
            'countryCode' => 'ID',
        ]);
    }
}
