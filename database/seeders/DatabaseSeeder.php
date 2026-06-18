<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AdminUserSeeder::class,
            ProfilSekolahSeeder::class,
            AcademicYearSeeder::class,
            FeeTypeSeeder::class,
            TariffSeeder::class,
            PPBDSeeder::class,
        ]);
    }
}
