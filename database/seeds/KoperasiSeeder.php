<?php

use App\Model\Koperasi;
use Illuminate\Database\Seeder;

class KoperasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $koperasi = new Koperasi();
        $koperasi->nama       = "Minimartket Manahijul Huda";
        $koperasi->api_token  = bcrypt("minimart");
        $koperasi->save();
    }
}
