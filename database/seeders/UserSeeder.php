<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'     => 'Fernando',
            'lastname'      => 'Rz',
            'email'         => 'fernando@octano.io',
            'celular'       => '0981134470',
            'password'      => Hash::make('soyoctano90'),
            'provider'      => 'default',
            'provider_id'   => '1',
            'created_at'    => now(),
            'updated_at'    => now()
        ])->assignRole('administrador'); 
    }
}
