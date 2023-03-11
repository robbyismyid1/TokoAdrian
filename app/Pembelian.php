<?php

namespace App;

use App\Pemasok;
use App\Produk;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    //
    protected $guarded = [];
    protected $qtys = [
        'quantity' => 'array',
    ];

    public function pemasok()
    {
        return $this->belongsTo(Pemasok::class);
    }

    public function produk()
    {
        return $this->belongsToMany(Produk::class, 'pembelian_produk', 'pembelian_id', 'produk_id')->withPivot('quantity');
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
