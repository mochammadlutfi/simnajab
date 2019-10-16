<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTPTTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tpt', function (Blueprint $table) {
            $table->bigIncrements('tpt_id');
            $table->integer('jalan_id')->unsigned();
            $table->enum('pasang_batu', ['1', '0']);
            $table->enum('beton', ['1', '0']);
            $table->enum('kondisi', ['baik', 'sedang', 'rusak ringan', 'rusak berat']);
            $table->enum('posisi', ['kiri', 'kanan', 'kiri dan kanan']);
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
        Schema::dropIfExists('tpt');
    }
}
