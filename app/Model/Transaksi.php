<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Transaksi extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'transaksi';
    public $timestamps = false;
    protected $fillable = [
		'tanggal',
        'saldo',
        'jumlah',
        'jenis_transaksi_id',
        'nasabah_id',
        'pegawai_id',
        'koperasi_id',
        'no_referensi',
	];

    public function koperasi()
    {
        return $this->belongsTo(Koperasi::class, 'koperasi_id');
    }

    public function jenis_transaksi()
    {
        return $this->belongsTo(JenisTransaksi::class, 'jenis_transaksi_id');
    }

    public function nasabah()
    {
        return $this->belongsTo(Nasabah::class, 'nasabah_id');
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }
}
