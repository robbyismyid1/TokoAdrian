<?php

namespace App;

use App\Pembelian;
use Illuminate\Database\Eloquent\Model;

class Pemasok extends Model
{
    //
    protected $guarded = [];

    public function pembelian()
    {
        return $this->hasMany(Pembelian::class);
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
