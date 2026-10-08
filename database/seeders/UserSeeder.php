<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Fray',
            'email' => 'ufonefray@gmail.com',
            'password' => 'fray2002',
        ]);
    }
}
