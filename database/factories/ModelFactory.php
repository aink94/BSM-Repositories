<?php


use App\Model\Nasabah;

$factory->define(Nasabah::class, function (Faker\Generator $faker) {
    return [
        'uid'  => $faker->unique()->ean8,
        'nis'  => $faker->unique()->isbn10,
        'nama' => $faker->name,
        'status_kartu' => ['GOLD', 'SILVER'][rand(0,1)],
    ];
});

$factory->define(\App\Model\Transaksi::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'tanggal'  => $faker->dateTimeThisYear($max = 'now'),
        'saldo'  => rand(200000,1000000),
        'jumlah' => rand(2000,10000),
        //'pegawai_id' => rand(1,3),
        'jenis_transaksi_id' => 3,//rand(1,3),
        'nasabah_id' => rand(1,300),
        'no_referensi' => rand(4444,99999),
        'koperasi_id' => 1,
    ];
});
