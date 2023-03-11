<?php

namespace App;

use App\Kategori;
use App\Penjualan;
use App\Pembelian;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    //
    protected $guarded = [];
    protected $appends = ['image_path', 'profit'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function penjualan()
    {
        return $this->belongsToMany(Penjualan::class, 'penjualan_produk', 'produk_id', 'penjualan_id');
    }

    public function pembelian()
    {
        return $this->belongsToMany(Pembelian::class, 'pembelian_produk', 'produk_id', 'pembelian_id');
    }

    public function getImagePathAttribute()
    {
        return asset('uploads/product_images/' . $this->image);
    }

    public function getProfitAttribute()
    {
        $profit = $this->harga_penjualan - $this->harga_pembelian;
        return $profit;
    }
}
