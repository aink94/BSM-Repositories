<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class JenisTransaksi extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'jenis_transaksi';
    public $timestamps = false;
    protected $fillable = [
		'nama',
	];

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'jenis_transaksi_id');
    }

}
