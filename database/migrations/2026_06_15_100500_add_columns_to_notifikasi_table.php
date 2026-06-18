<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('notifikasi', function (Blueprint $table) {
            if (! Schema::hasColumn('notifikasi', 'title')) {
                $table->string('title')->nullable();
            }
            if (! Schema::hasColumn('notifikasi', 'message')) {
                $table->text('message')->nullable();
            }
            if (! Schema::hasColumn('notifikasi', 'target_type')) {
                $table->string('target_type', 50)->nullable();
            }
            if (! Schema::hasColumn('notifikasi', 'target_id')) {
                $table->unsignedBigInteger('target_id')->nullable();
            }
            if (! Schema::hasColumn('notifikasi', 'is_read')) {
                $table->boolean('is_read')->default(false);
            }
        });
    }

    public function down()
    {
        Schema::table('notifikasi', function (Blueprint $table) {
            $columns = [];
            foreach (['title', 'message', 'target_type', 'target_id', 'is_read'] as $column) {
                if (Schema::hasColumn('notifikasi', $column)) {
                    $columns[] = $column;
                }
            }
            if ($columns !== []) {
                $table->dropColumn($columns);
            }
        });
    }
};
