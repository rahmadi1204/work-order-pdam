<?php

namespace Database\Seeders;

use App\Models\Whatsapp;
use Illuminate\Database\Seeder;

class WhatsappSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Whatsapp::create([
            'phone' => '628123456789',
            'url_server' => 'https://wa.indesignplant.com',
        ]);
    }
}
