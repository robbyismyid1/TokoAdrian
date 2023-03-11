<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePenjualansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nomor_penjualan');
            $table->double('total');
            $table->double('diskon');
            $table->double('jumlah_total');
            $table->enum('status', ['dibayar', 'tidak dibayar', 'hutang']);
            $table->double('dibayar');
            $table->double('due'); // credit 
            $table->integer('klien_id')->unsigned();
            $table->foreign('klien_id')->references('id')->on('kliens')->onDelete('cascade');
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
        Schema::dropIfExists('penjualans');
    }
}
