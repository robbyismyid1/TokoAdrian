<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PembelianProduk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembelian_produk', function (Blueprint $table) {
            $table->integer('produk_id')->unsigned();
            $table->string('quantity');
            $table->foreign('produk_id')->references('id')->on('produks')->onDelete('cascade');
            $table->integer('pembelian_id')->unsigned();
            $table->foreign('pembelian_id')->references('id')->on('pembelians')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penjualan_produk');
    }
}
