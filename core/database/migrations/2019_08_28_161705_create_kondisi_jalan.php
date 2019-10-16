<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKondisiJalan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kondisi_jalan', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->integer('jalan_id')->unsigned();
            $table->decimal('pn_baik');
            $table->integer('pj_baik');
            $table->decimal('pn_sedang');
            $table->integer('pj_sedang');
            $table->decimal('pn_ringan');
            $table->integer('pj_ringan');
            $table->decimal('pn_parah');
            $table->integer('pj_parah');
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
        Schema::dropIfExists('kondisi_jalan');
    }
}
