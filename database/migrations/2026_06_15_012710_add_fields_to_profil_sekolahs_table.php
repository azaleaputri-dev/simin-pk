<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profil_sekolahs', function (Blueprint $table) {
            if (! Schema::hasColumn('profil_sekolahs', 'nama_sekolah')) {
                $table->string('nama_sekolah', 255);
            }
            if (! Schema::hasColumn('profil_sekolahs', 'npsn')) {
                $table->string('npsn', 20)->unique()->nullable();
            }
            if (! Schema::hasColumn('profil_sekolahs', 'alamat')) {
                $table->text('alamat')->nullable();
            }
            if (! Schema::hasColumn('profil_sekolahs', 'kecamatan')) {
                $table->string('kecamatan', 100)->nullable();
            }
            if (! Schema::hasColumn('profil_sekolahs', 'kabupaten')) {
                $table->string('kabupaten', 100)->nullable();
            }
            if (! Schema::hasColumn('profil_sekolahs', 'provinsi')) {
                $table->string('provinsi', 100)->nullable();
            }
            if (! Schema::hasColumn('profil_sekolahs', 'kode_pos')) {
                $table->string('kode_pos', 10)->nullable();
            }
            if (! Schema::hasColumn('profil_sekolahs', 'telepon')) {
                $table->string('telepon', 20)->nullable();
            }
            if (! Schema::hasColumn('profil_sekolahs', 'email')) {
                $table->string('email', 100)->nullable();
            }
            if (! Schema::hasColumn('profil_sekolahs', 'website')) {
                $table->string('website', 255)->nullable();
            }
            if (! Schema::hasColumn('profil_sekolahs', 'status')) {
                $table->enum('status', ['negeri', 'swasta'])->default('swasta');
            }
            if (! Schema::hasColumn('profil_sekolahs', 'akreditasi')) {
                $table->string('akreditasi', 5)->nullable();
            }
            if (! Schema::hasColumn('profil_sekolahs', 'tahun_berdiri')) {
                $table->year('tahun_berdiri')->nullable();
            }
            if (! Schema::hasColumn('profil_sekolahs', 'kepala_sekolah')) {
                $table->string('kepala_sekolah', 100)->nullable();
            }
            if (! Schema::hasColumn('profil_sekolahs', 'nip_kepala')) {
                $table->string('nip_kepala', 20)->nullable();
            }
            if (! Schema::hasColumn('profil_sekolahs', 'jumlah_guru')) {
                $table->integer('jumlah_guru')->default(0);
            }
            if (! Schema::hasColumn('profil_sekolahs', 'jumlah_siswa')) {
                $table->integer('jumlah_siswa')->default(0);
            }
            if (! Schema::hasColumn('profil_sekolahs', 'fasilitas')) {
                $table->json('fasilitas')->nullable();
            }
            if (! Schema::hasColumn('profil_sekolahs', 'deskripsi')) {
                $table->text('deskripsi')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('profil_sekolahs', function (Blueprint $table) {
            $table->dropColumn(['nama_sekolah', 'npsn', 'alamat', 'kecamatan', 'kabupaten', 'provinsi', 'kode_pos', 'telepon', 'email', 'website', 'status', 'akreditasi', 'tahun_berdiri', 'kepala_sekolah', 'nip_kepala', 'jumlah_guru', 'jumlah_siswa', 'fasilitas', 'deskripsi']);
        });
    }
};
