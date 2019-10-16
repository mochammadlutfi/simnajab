<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJembatanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jembatan', function (Blueprint $table) {
            $table->integerIncrements('jembatan_id');
            $table->integer('jalan_id')->unsigned();
            $table->enum('kondisi', ['baik', 'sedang', 'rusak ringan', 'rusak berat']);
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
        Schema::dropIfExists('jembatan');
    }
}
