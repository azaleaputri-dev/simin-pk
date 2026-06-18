<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::statement("UPDATE p_p_d_b_s SET status_pendaftaran = 'draft' WHERE status_pendaftaran = 'submitted'");
        DB::statement("ALTER TABLE p_p_d_b_s MODIFY status_pendaftaran ENUM('draft', 'diajak_tes', 'lulus_tes', 'waitlist', 'diterima', 'ditolak', 'batal') DEFAULT 'draft'");
    }

    public function down()
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::statement("UPDATE p_p_d_b_s SET status_pendaftaran = 'draft' WHERE status_pendaftaran = 'waitlist'");
        DB::statement("ALTER TABLE p_p_d_b_s MODIFY status_pendaftaran ENUM('draft', 'diajak_tes', 'lulus_tes', 'diterima', 'ditolak', 'batal') DEFAULT 'draft'");
    }
};
