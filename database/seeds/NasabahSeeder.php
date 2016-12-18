<?php

use Illuminate\Database\Seeder;

class NasabahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $n = new \App\Model\Nasabah();
        $n->uid  = "60CD9055";
        $n->nis  = "10112671";
        $n->nama = "Faisal Abdul Hamid";
        $n->status_kartu = "GOLD";
        $n->save();

        $na = new \App\Model\Nasabah();
        $na->uid  = "8510A743";
        $na->nis  = "10113487";
        $na->nama = "Azis Albanani";
        $na->status_kartu = "SILVER";
        $na->save();
    }
}
