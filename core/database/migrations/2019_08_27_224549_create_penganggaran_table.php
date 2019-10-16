<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePenganggaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penganggaran', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->integer('jalan_id')->unsigned();
            $table->enum('tujuan', ['jalan', 'jembatan', 'tpt', 'drainase']);
            $table->date('tgl');
            $table->string('perusahaan');
            $table->string('nomor_bast');
            $table->float('jml_anggaran', 10, 2);
            $table->timestamps();
            $table->foreign('jalan_id')->references('jalan_id')->on('jalan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penganggarans');
    }
}
