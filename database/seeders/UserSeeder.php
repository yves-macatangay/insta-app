<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = new User;

        $user->name = 'Isabelle';
        $user->email = 'i@mail.com';
        $user->password = Hash::make('password');
        $user->role_id = 1;
        $user->save();

        $users = [
            [
                'name' => 'Grace',
                'email' => 'g@mail.com',
                'password' => Hash::make('password'),
                'role_id' => 2,
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'name' => 'Harry',
                'email' => 'h@mail.com',
                'password' => Hash::make('password'),
                'role_id' => 2,
                'created_at' => NOW(),
                'updated_at' => NOW()
            ]
        ];
        $user->insert($users);

    }
}
