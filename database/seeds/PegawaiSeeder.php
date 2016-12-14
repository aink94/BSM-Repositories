<?php

use App\Model\Pegawai;
use Illuminate\Database\Seeder;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new Pegawai();
        $admin->nama = "Faisal Abdul Hamid";
        $admin->username = "admin";
        $admin->password = "123456";
        $admin->status = "ADMIN";
        $admin->save();

        $pegawai = new Pegawai();
        $pegawai->nama = "Andi Hidayat";
        $pegawai->username = "pegawai";
        $pegawai->password = "123456";
        $pegawai->status = "PEGAWAI";
        $pegawai->save();

        $manager = new Pegawai();
        $manager->nama = "Cecep Zaenal Mustofa";
        $manager->username = "manager";
        $manager->password = "123456";
        $manager->status = "MANAGER";
        $manager->save();

    }
}
