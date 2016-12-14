<?php

namespace App\Transformers;

use App\Model\Transaksi;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

/**
 * Class NotifikasiTransformer
 * @package namespace App\Transformers;
 */
class NotifikasiTransformer extends TransformerAbstract
{

    /**
     * Transform the \Notifikasi entity
     * @param \Notifikasi $model
     *
     * @return array
     */
    public function transform(Transaksi $model)
    {
        return [
            'waktu'    => Carbon::parse($model->tanggal)->diffForHumans(Carbon::now()),
            'nasabah'  => $model->nasabah->nama,
            'transaksi'=> $model->jenis_transaksi->nama,
            'jumlah'   => 'Rp.'.number_format($model->jumlah, 2, ',', '.') ,
            'lembaga'  => ($model->koperasi_id) ? $model->koperasi->nama : $model->pegawai->nama,

        ];
    }
}
