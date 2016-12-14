<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Nasabah extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'nasabah';

    protected $fillable = [
		'uid',
		'nis',
		'nama',
		'status_kartu',
	];

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'nasabah_id');
    }
}
