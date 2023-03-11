<?php

use Illuminate\Database\Seeder;

class KlienTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Klien::create([
            'nama_klien' => 'Tidak diketahui',
            'nik' => '-',
            'image' => '-',
            'telepon' => '-',
            'alamat' => '-',
            'deskripsi' => '-'
        ]);
    }
}