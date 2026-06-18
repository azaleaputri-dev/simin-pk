<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('parents', function (Blueprint $table) {
            if (! Schema::hasColumn('parents', 'name')) {
                $table->string('name')->nullable()->after('user_id');
            }

            if (! Schema::hasColumn('parents', 'email')) {
                $table->string('email')->nullable()->unique()->after('name');
            }
        });
    }

    public function down()
    {
        Schema::table('parents', function (Blueprint $table) {
            if (Schema::hasColumn('parents', 'email')) {
                $table->dropUnique('parents_email_unique');
            }

            $columns = [];

            foreach (['name', 'email'] as $column) {
                if (Schema::hasColumn('parents', $column)) {
                    $columns[] = $column;
                }
            }

            if ($columns !== []) {
                $table->dropColumn($columns);
            }
        });
    }
};
