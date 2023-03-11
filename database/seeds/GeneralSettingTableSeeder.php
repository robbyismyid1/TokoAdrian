<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class GeneralSettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\GeneralSetting::create([
            'nama_toko' => 'Toko Adrian',
            'deskripsi' => 'Tempat beli sembako dan jajanan murah dan terpercaya',
            'telepon' => '082128963842',
            'alamat' => 'Jl. Pasawahan No.34, Sukamenak, Kec. Margahayu, Bandung, Jawa Barat 40252',
            'tanggal_mulai' => Carbon::parse('2001-04-11'),
            'image' => 'logo_default.png'
        ]);
    }
}