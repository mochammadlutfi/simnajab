<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNJOPTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('njop', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->integer('jalan_id')->unsigned();
            $table->float('jml_anggaran', 10, 2);
            $table->date('tgl');
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
        Schema::dropIfExists('njop');
    }
}
