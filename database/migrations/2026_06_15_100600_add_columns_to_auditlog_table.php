<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('auditlog', function (Blueprint $table) {
            if (! Schema::hasColumn('auditlog', 'action')) {
                $table->string('action')->nullable();
            }
            if (! Schema::hasColumn('auditlog', 'entity_type')) {
                $table->string('entity_type', 50)->nullable();
            }
            if (! Schema::hasColumn('auditlog', 'entity_id')) {
                $table->unsignedBigInteger('entity_id')->nullable();
            }
            if (! Schema::hasColumn('auditlog', 'description')) {
                $table->text('description')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('auditlog', function (Blueprint $table) {
            $columns = [];
            foreach (['action', 'entity_type', 'entity_id', 'description'] as $column) {
                if (Schema::hasColumn('auditlog', $column)) {
                    $columns[] = $column;
                }
            }
            if ($columns !== []) {
                $table->dropColumn($columns);
            }
        });
    }
};
