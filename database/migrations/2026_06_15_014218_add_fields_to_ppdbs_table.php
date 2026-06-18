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
        Schema::table('p_p_d_b_s', function (Blueprint $table) {
            if (! Schema::hasColumn('p_p_d_b_s', 'nama_lengkap')) {
                $table->string('nama_lengkap', 100);
            }
            if (! Schema::hasColumn('p_p_d_b_s', 'nik')) {
                $table->string('nik', 16)->unique()->nullable();
            }
            if (! Schema::hasColumn('p_p_d_b_s', 'tanggal_lahir')) {
                $table->date('tanggal_lahir');
            }
            if (! Schema::hasColumn('p_p_d_b_s', 'jenis_kelamin')) {
                $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            }
            if (! Schema::hasColumn('p_p_d_b_s', 'tempat_lahir')) {
                $table->string('tempat_lahir', 50);
            }
            if (! Schema::hasColumn('p_p_d_b_s', 'agama')) {
                $table->string('agama', 20);
            }
            if (! Schema::hasColumn('p_p_d_b_s', 'alamat')) {
                $table->string('alamat', 255);
            }
            if (! Schema::hasColumn('p_p_d_b_s', 'rt')) {
                $table->string('rt', 5);
            }
            if (! Schema::hasColumn('p_p_d_b_s', 'rw')) {
                $table->string('rw', 5);
            }
            if (! Schema::hasColumn('p_p_d_b_s', 'dusun')) {
                $table->string('dusun', 50)->nullable();
            }
            if (! Schema::hasColumn('p_p_d_b_s', 'kelurahan')) {
                $table->string('kelurahan', 50);
            }
            if (! Schema::hasColumn('p_p_d_b_s', 'kecamatan')) {
                $table->string('kecamatan', 50);
            }
            if (! Schema::hasColumn('p_p_d_b_s', 'kabupaten')) {
                $table->string('kabupaten', 50);
            }
            if (! Schema::hasColumn('p_p_d_b_s', 'provinsi')) {
                $table->string('provinsi', 50);
            }
            if (! Schema::hasColumn('p_p_d_b_s', 'kode_pos')) {
                $table->string('kode_pos', 10);
            }
            if (! Schema::hasColumn('p_p_d_b_s', 'no_telp')) {
                $table->string('no_telp', 15);
            }
            if (! Schema::hasColumn('p_p_d_b_s', 'email')) {
                $table->string('email', 100)->nullable();
            }
            if (! Schema::hasColumn('p_p_d_b_s', 'asal_sekolah')) {
                $table->string('asal_sekolah', 100);
            }
            if (! Schema::hasColumn('p_p_d_b_s', 'nisn_asal')) {
                $table->string('nisn_asal', 16)->nullable();
            }
            if (! Schema::hasColumn('p_p_d_b_s', 'jalur_pendaftaran')) {
                $table->string('jalur_pendaftaran', 20);
            }
            if (! Schema::hasColumn('p_p_d_b_s', 'pilihan_jurusan')) {
                $table->string('pilihan_jurusan', 50)->nullable();
            }
            if (! Schema::hasColumn('p_p_d_b_s', 'status_pendaftaran')) {
                $table->enum('status_pendaftaran', ['draft', 'diajak_tes', 'lulus_tes', 'diterima', 'ditolak', 'batal'])->default('draft');
            }
            if (! Schema::hasColumn('p_p_d_b_s', 'tanggal_daftar')) {
                $table->date('tanggal_daftar')->nullable();
            }
            if (! Schema::hasColumn('p_p_d_b_s', 'tanggal_tes')) {
                $table->date('tanggal_tes')->nullable();
            }
            if (! Schema::hasColumn('p_p_d_b_s', 'tanggal_pengumuman')) {
                $table->date('tanggal_pengumuman')->nullable();
            }
            if (! Schema::hasColumn('p_p_d_b_s', 'berkas')) {
                $table->json('berkas')->nullable();
            }
            if (! Schema::hasColumn('p_p_d_b_s', 'catatan')) {
                $table->text('catatan')->nullable();
            }
            if (! Schema::hasColumn('p_p_d_b_s', 'user_id')) {
                $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
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
        Schema::table('p_p_d_b_s', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['nama_lengkap', 'nik', 'tanggal_lahir', 'jenis_kelamin', 'tempat_lahir', 'agama', 'alamat', 'rt', 'rw', 'dusun', 'kelurahan', 'kecamatan', 'kabupaten', 'provinsi', 'kode_pos', 'no_telp', 'email', 'asal_sekolah', 'nisn_asal', 'jalur_pendaftaran', 'pilihan_jurusan', 'status_pendaftaran', 'tanggal_daftar', 'tanggal_tes', 'tanggal_pengumuman', 'berkas', 'catatan', 'user_id']);
        });
    }
};
