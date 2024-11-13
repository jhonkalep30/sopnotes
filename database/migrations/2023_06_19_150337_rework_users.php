<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Schema::table('users', function (Blueprint $table) {

        //     $table->dropForeign(['direktorat_id']);
        //     $table->dropForeign(['unit_bisnis_id']);
        //     $table->dropForeign(['kota_id']);
        //     $table->dropForeign(['outlet_id']);
        //     $table->dropForeign(['jabatan_id']);

        // });

        // Schema::table('users', function (Blueprint $table) {
        //     $table->dropColumn(['direktorat_id', 'unit_bisnis_id', 'kota_id', 'outlet_id', 'jabatan_id']);
        // });

        // return;

        Schema::table('users', function (Blueprint $table) {
            $table->string('email')->nullable()->change();
        });

        // FOREIGN FIELDS
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('direktorat_id')->nullable()->after('role_id');
            $table->unsignedBigInteger('unit_bisnis_id')->nullable()->after('role_id');
            $table->unsignedBigInteger('kota_id')->nullable()->after('role_id');
            $table->unsignedBigInteger('outlet_id')->nullable()->after('role_id');
            $table->unsignedBigInteger('jabatan_id')->nullable()->after('role_id');

            $table->foreign('direktorat_id')->references('id')->on('direktorat');
            $table->foreign('unit_bisnis_id')->references('id')->on('unit_bisnis');
            $table->foreign('kota_id')->references('id')->on('kota');
            $table->foreign('outlet_id')->references('id')->on('outlets');
            $table->foreign('jabatan_id')->references('id')->on('jabatan');

        });

        // ADDITIONAL FIELDS
        Schema::table('users', function (Blueprint $table) {

            $table->text('jenis_kelamin')->nullable();
            $table->text('status')->nullable();
            $table->text('npp')->nullable();
            $table->text('id_his')->nullable();
            $table->text('plt_penugasan')->nullable();
            $table->date('tmb_plt')->nullable();
            $table->text('masa_kerja_plt')->nullable();
            $table->text('cost_center')->nullable();
            $table->text('outlet_inhouse')->nullable();
            $table->text('strata_unit_bisnis')->nullable();
            $table->text('kelas_outlet')->nullable();
            $table->text('pendidikan')->nullable();
            $table->text('jurusan')->nullable();
            $table->text('alumni_pendidikan')->nullable();
            $table->text('tanggal_lulus')->nullable();
            $table->text('gelar_profesi')->nullable();
            $table->text('alumni_pendidikan_profesi')->nullable();
            $table->text('tahun_lulus_profesi')->nullable();
            $table->text('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->text('tmb')->nullable();
            $table->text('masa_kerja')->nullable();
            $table->text('tmb_jabatan_saat_ini')->nullable();
            $table->text('masa_kerja_jabatan_saat_ini')->nullable();
            $table->text('tmb_kenaikan_level')->nullable();
            $table->text('tanggal_pj_penuh')->nullable();
            $table->text('tmb_pt')->nullable();
            $table->text('masa_kerja_pt')->nullable();
            $table->text('grading')->nullable();
            $table->text('eselon')->nullable();
            $table->text('spk_i')->nullable();
            $table->text('spk_ii')->nullable();
            $table->text('spk_iii')->nullable();
            $table->text('spk_iv')->nullable();
            $table->text('spk_v')->nullable();
            $table->text('habis_kontrak')->nullable();
            $table->text('domisili_asal')->nullable();
            $table->text('alamat_ktp')->nullable();
            $table->text('kelurahan')->nullable();
            $table->text('kecamatan')->nullable();
            $table->text('kota')->nullable();
            $table->text('provinsi')->nullable();
            $table->text('kode_pos')->nullable();
            $table->text('agama')->nullable();
            $table->text('ktp')->nullable();
            $table->text('no_tlp')->nullable();
            $table->text('alamat_email')->nullable();
            $table->text('no_tlp_keluarga')->nullable();
            $table->text('alamat_sesuai_npwp')->nullable();
            $table->text('npwp')->nullable();
            $table->text('nama_ibu')->nullable();
            $table->text('nama_ayah')->nullable();
            $table->text('bpjs_kes')->nullable();
            $table->text('no_rek')->nullable();
            $table->text('status_kawin_npwp')->nullable();
            $table->text('golongan_darah')->nullable();
            $table->text('status_kawin')->nullable();
            $table->text('jml_anak')->nullable();
            $table->text('jml_anggota_keluarga')->nullable();
            $table->text('nama_pasangan')->nullable();
            $table->text('anak_1')->nullable();
            $table->text('anak_2')->nullable();
            $table->text('anak_3')->nullable();
            $table->text('anak_4')->nullable();
            $table->text('anak_5')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('email')->change();
        });

        // FOREIGN FIELDS
        Schema::table('users', function (Blueprint $table) {

            $table->dropForeign(['direktorat_id']);
            $table->dropForeign(['unit_bisnis_id']);
            $table->dropForeign(['kota_id']);
            $table->dropForeign(['outlet_id']);
            $table->dropForeign(['jabatan_id']);

        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['direktorat_id', 'unit_bisnis_id', 'kota_id', 'outlet_id', 'jabatan_id']);
        });

        // ADDITIONAL FIELDS
        Schema::table('users', function (Blueprint $table) {

            $table->dropColumn([
                'jenis_kelamin',
                'status',
                'npp',
                'id_his',
                'plt_penugasan',
                'tmb_plt',
                'masa_kerja_plt',
                'cost_center',
                'outlet_inhouse',
                'strata_unit_bisnis',
                'kelas_outlet',
                'pendidikan',
                'jurusan',
                'alumni_pendidikan',
                'tanggal_lulus',
                'gelar_profesi',
                'alumni_pendidikan_profesi',
                'tahun_lulus_profesi',
                'tempat_lahir',
                'tanggal_lahir',
                'tmb',
                'masa_kerja',
                'tmb_jabatan_saat_ini',
                'masa_kerja_jabatan_saat_ini',
                'tmb_kenaikan_level',
                'tanggal_pj_penuh',
                'tmb_pt',
                'masa_kerja_pt',
                'grading',
                'eselon',
                'spk_i',
                'spk_ii',
                'spk_iii',
                'spk_iv',
                'spk_v',
                'habis_kontrak',
                'domisili_asal',
                'alamat_ktp',
                'kelurahan',
                'kecamatan',
                'kota',
                'provinsi',
                'kode_pos',
                'agama',
                'ktp',
                'no_tlp',
                'alamat_email',
                'no_tlp_keluarga',
                'alamat_sesuai_npwp',
                'npwp',
                'nama_ibu',
                'nama_ayah',
                'bpjs_kes',
                'no_rek',
                'status_kawin_npwp',
                'golongan_darah',
                'status_kawin',
                'jml_anak',
                'jml_anggota_keluarga',
                'nama_istri/suami',
                'anak_1',
                'anak_2',
                'anak_3',
                'anak_4',
                'anak_5'
            ]);

        });
    }
};
