<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('academic_years', function (Blueprint $table) {
            $table->boolean('ppdb_is_open')->default(false)->after('quota');
            $table->date('ppdb_start_date')->nullable()->after('ppdb_is_open');
            $table->date('ppdb_end_date')->nullable()->after('ppdb_start_date');
        });
    }

    public function down()
    {
        Schema::table('academic_years', function (Blueprint $table) {
            $table->dropColumn(['ppdb_is_open', 'ppdb_start_date', 'ppdb_end_date']);
        });
    }
};
