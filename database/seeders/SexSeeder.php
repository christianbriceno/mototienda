<?php

namespace Database\Seeders;

use App\Models\Sex;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SexSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sexes = [
            [
                'name' => 'Masculino',
            ],
            [
                'name' => 'Femenino',
            ]
        ];

        foreach ($sexes as $sex) {
            Sex::factory()->create([
                'name'     => $sex['name'],
            ]);
        }
    }
}
