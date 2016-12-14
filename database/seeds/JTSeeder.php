<?php

use App\Model\JenisTransaksi;
use Illuminate\Database\Seeder;

class JTSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jt_1 = new JenisTransaksi();
        $jt_1->nama = "Penyimpanan";
        $jt_1->save();

        $jt_2 = new JenisTransaksi();
        $jt_2->nama = "Pengambilan";
        $jt_2->save();

        $jt_3 = new JenisTransaksi();
        $jt_3->nama = "Pembelajaan";
        $jt_3->save();
    }
}
