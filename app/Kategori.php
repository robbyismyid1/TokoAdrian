<?php

namespace App;

use App\Produk;
use Illuminate\Database\Eloquent\Model;
use Session;

class Kategori extends Model
{
    //
    protected $guarded = [];
    
    public function produk()
    {
        return $this->hasMany(Produk::class);
    }

    public static function boot()
	{
		parent::boot();
		self::deleting(function ($kategori_id) {
			// mengecek apakah penulis masih punya buku
			if ($kategori_id->produk->count() > 0) {
				// menyiapkan pesan error
				$html = 'Kategori tidak bisa dihapus karena masih memiliki data:';
				$html .= '<ul>';
				foreach ($kategori_id->produk as $data) {
					$html .= "<li>$data->nama_produk</li>";
				}
				$html .= '</ul>';
				Session::flash("flash_notification", [
					"level" => "danger",
					"message" => $html,
				]);
				// membatalkan proses penghapusan
				return false;
			}
			else {
                
			}
		});
	}
}
