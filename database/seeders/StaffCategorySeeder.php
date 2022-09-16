<?php

namespace Database\Seeders;

use App\Models\Data\StaffCategory;
use Illuminate\Database\Seeder;

class StaffCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StaffCategory::updateOrCreate([
            'uuid' => '1.00.00.00.00',
        ], [
            'name' => 'Direktur Utama',
        ]);
        StaffCategory::updateOrCreate([
            'uuid' => '2.00.00.00.00',
        ], [
            'name' => 'Direktur Administrasi & Keuangan',
        ]);
        StaffCategory::updateOrCreate([
            'uuid' => '3.00.00.00.00',
        ], [
            'name' => 'Direktur Administrasi & Keuangan',
        ]);
    }
}
