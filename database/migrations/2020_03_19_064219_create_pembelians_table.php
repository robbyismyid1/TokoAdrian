<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePembeliansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembelians', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nomor_pembelian');
            $table->double('total');
            $table->double('diskon');
            $table->double('jumlah_total');
            $table->enum('status', ['dibayar', 'tidak dibayar', 'hutang']);
            $table->double('dibayar');
            $table->double('due'); // credit 
            $table->integer('pemasok_id')->unsigned();
            $table->foreign('pemasok_id')->references('id')->on('pemasoks')->onDelete('cascade');
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
        Schema::dropIfExists('pembelians');
    }
}
