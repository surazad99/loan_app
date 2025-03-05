<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Create an admin
        User::factory()->create([
            'email' => 'super.admin@gmail.com', 
            'password' =>  Hash::make('password'), 
            'role' => 'admin'
        ]);

        //create borrowers
        User::factory(2)->create();
    }
}
