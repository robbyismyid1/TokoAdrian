<?php

use Illuminate\Database\Seeder;

class PemasokTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Pemasok::create([
            'nama_pemasok' => 'Tidak diketahui',
            'telepon' => '-',
            'alamat' => '-',
            'deskripsi' => '-'
        ]);
    }
}