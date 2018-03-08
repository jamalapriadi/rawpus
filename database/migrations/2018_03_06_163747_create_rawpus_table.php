<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRawpusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status_ketenagaan', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name',191);
            $table->timestamps();
        });

        Schema::create('jabatan',function(Blueprint $table){
            $table->increments('id')->unsigned();
            $table->integer('status_ketenagaan_id')->unsigned();
            $table->string('name',191);
            $table->timestamps();
        });

        Schema::create('tenaga_medis',function(Blueprint $table){
            $table->increments('id')->unsigned();
            $table->integer('jabatan_id')->unsigned();
            $table->string('name',191);
            $table->string('alamat',191);
            $table->string('no_telp',15);
            $table->timestamps();
        });

        Schema::create('pasien',function(Blueprint $table){
            $table->increments('id')->unsigned();
            $table->string('no_kartu',65)->unique();
            $table->string('nama_peserta');
            $table->enum('sex',['L','P']);
            $table->date('tgl_lahir');
            $table->string('pekerjaan',191);
            $table->string('alamat',191);
            $table->timestamps();
        });

        Schema::create('diagnosa',function(Blueprint $table){
            $table->increments('id')->unsigned();
            $table->string('kode_icd',15)->unique();
            $table->string('diagnosa');
            $table->timestamps();
        });

        Schema::create('kunjungan',function(Blueprint $table){
            $table->string('no_pendaftaran',30)->primary();
            $table->date('tgl_pendaftaran');
            $table->string('no_urut');
            $table->string('no_kartu');
            $table->string('jenis_kunjungan',45);
            $table->string('perawatan',30);
            $table->string('poli_tujuan',30);
            $table->string('keluhan',191);
            $table->string('tinggi_badan',10);
            $table->string('berat_badan',10);
            $table->string('sistole',10);
            $table->string('diastole',10);
            $table->string('respiratory_rate',10);
            $table->string('heart_rate',10);
            $table->string('insert_user',65);
            $table->string('update_user',65);
            $table->timestamps();
        });

        Schema::create('pelayanan',function(Blueprint $table){
            $table->increments('id')->unsigned();
            $table->date('tgl_pendaftaran');
            $table->string('poli');
            $table->string('sumber_data',15);
            $table->string('no_pendaftaran_atau_kartu',30);
            $table->string('terapi',191);
            $table->integer('diagnosa_id')->unsigned();
            $table->string('kesadaran',191);
            $table->integer('tenaga_medis_id')->unsigned();
            $table->string('status_pulang',45);
            $table->string('insert_user',65);
            $table->string('update_user',65);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('status_ketenagaan');
    }
}
