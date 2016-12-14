<?php
/**
 * Created by PhpStorm.
 * User: Faisal Abdul Hamid
 * Date: 09/12/2016
 * Time: 16:57
 */

namespace App\Transformers;


use App\Model\Transaksi;
use League\Fractal\TransformerAbstract;

class TransaksiTransformer extends TransformerAbstract
{
    public function transform(Transaksi $model)
    {
        return [
            'id'             => (int) $model->id,
            'nasabah'        => $model->nasabah->nama,
            'tanggal'        => $model->tanggal,
            'jumlah'         => 'Rp.'.number_format($model->jumlah, '2', ',', '.'),
            'jenis_transaksi'=> $model->jenis_transaksi->nama,

        ];
    }
}