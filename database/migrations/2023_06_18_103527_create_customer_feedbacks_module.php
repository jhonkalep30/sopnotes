<?php

use App\Models\NPS\ScoringTag;
use App\Models\NPS\ScoringValue;
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
        Schema::create('scoring_values', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->integer('value');
            $table->string('level');
            $table->timestamps();
            $table->softDeletes();
        });

        for($i=0;$i<=10;$i++){
            $level = 'Detractors';
            if(in_array($i,[7,8])) $level = 'Passives';
            if(in_array($i,[9,10])) $level = 'Promoters';

            ScoringValue::firstOrCreate([
                'label' => $i,
                'value' => $i,
            ],[
                'level' => $level
            ]);
        }

        Schema::create('scoring_tags', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->string('value');
            $table->string('level');
            $table->integer('show_freetext')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        $default = ['Lambat','Antri','Kurang Ramah','Kotor','Tidak Lengkap','Nyeri','Tidak Diberi Rujukan','Lainnya'];
        foreach(['Detractors','Passives'] as $level){
            foreach($default as $item){
                ScoringTag::firstOrCreate([
                    'label' => $item,
                    'value' => $item,
                    'level' => $level,
                ],[
                    'show_freetext' => $item == 'Lainnya' ? 1 : 0
                ]);         
            }
        }

        $high = ['Cepat','Ramah','Bersih','Lengkap','Tidak Sakit','Tidak Antri','Lainnya'];
        foreach($high as $item){
            ScoringTag::firstOrCreate([
                'label' => $item,
                'value' => $item,
                'level' => 'Promoters',
            ],[
                'show_freetext' => $item == 'Lainnya' ? 1 : 0
            ]);         
        }

        Schema::create('staging_data', function (Blueprint $table) {
            $table->id();

            // General
            $table->string('id_transaksi')->index();
            $table->date('tanggal_transaksi')->nullable();
            $table->time('waktu_transaksi')->nullable();
            $table->string('nama_bm')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('email')->nullable();
            $table->string('nomor_hp')->nullable();
            $table->string('penjamin')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->string('kategori_pasien')->nullable();
            $table->string('nomor_rm')->nullable();

            // Klinik
            $table->string('nama_klinik')->nullable();
            $table->string('nama_user')->nullable();
            $table->string('jenis_pasien')->nullable();
            $table->string('nama_pasien')->nullable();
            $table->string('nama_dokter')->nullable();
            $table->string('jenis_tindakan')->nullable();
            $table->text('diagnosa_pasien')->nullable();

            // Lab
            $table->string('nama_dokter_pengirim')->nullable();
            $table->string('nama_lab')->nullable();
            $table->string('nama_lengkap')->nullable();
            $table->string('segmen')->nullable();
            $table->string('jenis_pemeriksaan')->nullable();

            // For Backend Logic Purpose
            $table->string('data_type')->nullable(); // klinik or lab
            $table->tinyInteger('is_published')->default(0);
            $table->datetime('publish_time')->nullable();
            $table->tinyInteger('is_wa')->default(0);
            $table->tinyInteger('is_answered')->default(0);
            $table->text('url')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('net_promoter_scores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('staging_data_id');
            $table->integer('value');
            $table->string('level');
            $table->text('tags');
            $table->text('notes')->nullable();
            $table->text('master_scorings');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('staging_data_id')->references('id')->on('staging_data');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('net_promoter_scores', function (Blueprint $table) {
            $table->dropForeign(['staging_data_id']);
        });

        Schema::dropIfExists('net_promoter_scores');
        Schema::dropIfExists('staging_data');
        Schema::dropIfExists('scoring_values');
        Schema::dropIfExists('scoring_tags');
    }
};
