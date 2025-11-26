<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Client::factory()->create([
            'name'                => config('permission.consumidor_final_name'),
            'last_name'           => config('permission.consumidor_final_last_name'),
            'identification_card' => config('permission.consumidor_final_identification_card'),
            'address'             => config('permission.consumidor_final_address'),
            'email'               => config('permission.consumidor_final_email'),
            'phone'               => config('permission.consumidor_final_phone'),
        ]);
    }
}
