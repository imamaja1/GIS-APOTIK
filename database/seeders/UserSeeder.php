<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'nama_user'  => 'Budi Santoso',
                'email'      => 'budi@gis-klu.test',
                'password'   => Hash::make('password'),
            ],
            [
                'nama_user'  => 'Siti Rahayu',
                'email'      => 'siti@gis-klu.test',
                'password'   => Hash::make('password'),
            ],
            [
                'nama_user'  => 'Ahmad Fauzi',
                'email'      => 'ahmad@gis-klu.test',
                'password'   => Hash::make('password'),
            ],
        ];

        foreach ($users as $user) {
            User::firstOrCreate(['email' => $user['email']], $user);
        }

        $this->command->info('  ✓ UserSeeder: ' . count($users) . ' user dibuat.');
        $this->command->line('    Login test → email: budi@gis-klu.test | password: password');
    }
}
