<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $admins = [
            // [
            //     'name' => 'Vicheth Chan',
            //     'ngo' => 'NGO Forum Cambodia',
            //     'email' => 'support@ngoforum.org.kh',
            //     'role' => 'admin',
            //     'password' => 'UnifiP@$$w0rd'
            // ],
            [
                'name' => 'Vicheth Chan',
                'ngo' => 'NGO Forum Cambodia',
                'email' => 'vicheth@ngoforum.org.kh',
                'role' => 'admin',
                'password' => 'NecaAwg*2023'
            ],
            [
                'name' => 'Mengseu Sork',
                'ngo' => 'NGO Forum Cambodia',
                'email' => 'mengseu.sork@student.passerellesnumeriques.org',
                'role' => 'admin',
                'password' => '123456789'
            ]
        ];

        foreach ($admins as $admin) {
            User::create([
                'name' => $admin['name'],
                'ngo' => $admin['ngo'],
                'email' => $admin['email'],
                'role' => $admin['role'],
                'password' => Hash::make($admin['password']),
            ]);
        }
    }
}

