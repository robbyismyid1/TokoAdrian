<?php

namespace App;

use App\Penjualan;
use Illuminate\Database\Eloquent\Model;

class Klien extends Model
{
    //
    protected $guarded = [];
    protected $appends = ['image_path'];

    public function penjualan()
    {
        return $this->hasMany(Penjualan::class);
    }

    public function getImagePathAttribute()
    {
        return asset('uploads/klien_images/' . $this->image);
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
