<?php

namespace App;

use App\Klien;
use App\Produk;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    //
    protected $guarded = [];
    protected $qtys = [
        'quantity' => 'array',
    ];

    public function klien()
    {
        return $this->belongsTo(Klien::class);
    }

    public function produk()
    {
        return $this->belongsToMany(Produk::class, 'penjualan_produk', 'penjualan_id', 'produk_id')->withPivot('quantity');
    }
    
    public function getCreatedAtAttribute()
    {
    return \Carbon\Carbon::parse($this->attributes['created_at'])
       ->format('d M Y');
    }

    public function getUpdatedAtAttribute()
    {
    return \Carbon\Carbon::parse($this->attributes['updated_at'])
       ->diffForHumans();
    }
}
