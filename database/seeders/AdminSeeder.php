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
        $admin = User::create([
            'name' => 'Vicheth Chan', 
            'ngo' => 'NGO Forum Cambodia',
            'email' => 'support@ngoforum.org.kh',
            'role' => 'admin',
            'password' => Hash::make('UnifiP@$$w0rd')
        ]);
    }
}

