<?php

namespace Database\Seeders;

use App\Models\FeeType;
use Illuminate\Database\Seeder;

class FeeTypeSeeder extends Seeder
{
    public function run()
    {
        $items = [
            ['name' => 'Registrasi', 'code' => 'REGISTRASI'],
            ['name' => 'SPP', 'code' => 'SPP'],
            ['name' => 'Seragam', 'code' => 'SERAGAM'],
            ['name' => 'Buku', 'code' => 'BUKU'],
        ];

        foreach ($items as $item) {
            FeeType::updateOrCreate(
                ['code' => $item['code']],
                [
                    'name' => $item['name'],
                    'description' => 'Seed awal jenis biaya ' . $item['name'],
                    'is_active' => true,
                ]
            );
        }
    }
}
