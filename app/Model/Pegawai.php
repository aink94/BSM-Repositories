<?php

namespace App\Model;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Pegawai extends Model implements Transformable, Authenticatable
{
    use \Illuminate\Auth\Authenticatable;
    use TransformableTrait;

    protected $table = 'pegawai';
    //protected $hidden = ["password"];
    protected $fillable = [
        'id',
		'nama',
		'username',
		'status',
        'password',
        'create_at'
	];

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'pegawai_id');
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }


}
