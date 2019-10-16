<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBetonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('betons', function (Blueprint $table) {
            $table->integerIncrements('beton_id');
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
        Schema::dropIfExists('beton');
    }
}
