<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('p_p_d_b_s', function (Blueprint $table) {
            if (! Schema::hasColumn('p_p_d_b_s', 'nama_orang_tua')) {
                $table->string('nama_orang_tua', 100)->nullable()->after('email');
            }

            if (! Schema::hasColumn('p_p_d_b_s', 'email_orang_tua')) {
                $table->string('email_orang_tua', 100)->nullable()->after('nama_orang_tua');
            }

            if (! Schema::hasColumn('p_p_d_b_s', 'no_hp_orang_tua')) {
                $table->string('no_hp_orang_tua', 20)->nullable()->after('email_orang_tua');
            }
        });
    }

    public function down()
    {
        Schema::table('p_p_d_b_s', function (Blueprint $table) {
            $columns = [];

            foreach (['nama_orang_tua', 'email_orang_tua', 'no_hp_orang_tua'] as $column) {
                if (Schema::hasColumn('p_p_d_b_s', $column)) {
                    $columns[] = $column;
                }
            }

            if ($columns !== []) {
                $table->dropColumn($columns);
            }
        });
    }
};
