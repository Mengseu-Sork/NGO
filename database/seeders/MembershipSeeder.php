<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ngo;


class MembershipSeeder extends Seeder
{

    public function run()
    {
        $ngos = [
            ['ngo_name' => 'Passerelles Numeriques Cambodia', 'abbreviation' => 'PNC'],
        ];

        foreach ($ngos as $ngo) {
            Ngo::create($ngo);
        }
    }
}
