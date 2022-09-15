<?php

namespace Database\Seeders;

use App\Models\User;
use GuzzleHttp\Promise\Create;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'uuid' => 'USR-001',
            'name' => 'Super Admin',
            'username' => 'superadmin',
            'role' => 'super admin',
            'email' => 'superadmin@test.com',
            'password' => bcrypt('password'),
        ]);
        User::create([
            'uuid' => 'USR-002',
            'name' => 'Admin',
            'username' => 'admin',
            'role' => 'admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
        ]);
        User::create([
            'uuid' => 'USR-003',
            'name' => 'User',
            'username' => 'user',
            'role' => 'user',
            'email' => 'user@test.com',
            'password' => bcrypt('password'),
        ]);
    }
}
