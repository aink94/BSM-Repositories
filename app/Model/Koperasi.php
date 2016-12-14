<?php

namespace App\Model;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Koperasi extends Model implements Transformable, Authenticatable
{
    use \Illuminate\Auth\Authenticatable;
    use TransformableTrait;

    protected $table = 'koperasi';

    protected $fillable = [
		'nama',
        'token',
        'key'
	];

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'koperasi_id');
    }

}
