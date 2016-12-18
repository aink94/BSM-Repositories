<?php

use App\Model\Nasabah;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(JTSeeder::class);
        $this->call(KoperasiSeeder::class);
        $this->call(PegawaiSeeder::class);

        $this->call(NasabahSeeder::class);
        factory(Nasabah::class, 298)->create();
        factory(\App\Model\Transaksi::class, 300)->create();

    }
}
