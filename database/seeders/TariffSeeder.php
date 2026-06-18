<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\FeeType;
use App\Models\Tariff;
use Illuminate\Database\Seeder;

class TariffSeeder extends Seeder
{
    public function run()
    {
        $year = AcademicYear::where('name', '2026/2027')->first();

        if (! $year) {
            return;
        }

        $tariffs = [
            'REGISTRASI' => ['name' => 'Registrasi Siswa Baru 2026/2027', 'amount' => 750000],
            'SPP' => ['name' => 'SPP Bulanan 2026/2027', 'amount' => 350000],
            'SERAGAM' => ['name' => 'Paket Seragam 2026/2027', 'amount' => 500000],
        ];

        foreach ($tariffs as $code => $data) {
            $feeType = FeeType::where('code', $code)->first();
            if (! $feeType) {
                continue;
            }

            Tariff::updateOrCreate(
                [
                    'name' => $data['name'],
                    'fee_type_id' => $feeType->id,
                    'academic_year_id' => $year->id,
                ],
                [
                    'amount' => $data['amount'],
                    'is_active' => true,
                ]
            );
        }
    }
}
