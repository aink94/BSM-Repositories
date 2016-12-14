<?php

namespace App\Transformers;

use App\Model\Transaksi;
use League\Fractal\TransformerAbstract;

/**
 * Class DetailTransaksiNasabahTransformer
 * @package namespace App\Transformers;
 */
class DetailTransaksiNasabahTransformer extends TransformerAbstract
{

    /**
     * Transform the \DetailTransaksiNasabah entity
     * @param \DetailTransaksiNasabah $model
     *
     * @return array
     */
    public function transform(Transaksi $model)
    {
        return [
            'tanggal'         => $model->tanggal,
            'jumlah'          => 'Rp.'.number_format($model->jumlah, 2, ',', '.'),
            'saldo'           => 'Rp.'.number_format($model->saldo, 2, ',', '.'),
            'jenis_transaksi' => $model->jenis_transaksi->nama
        ];
    }
}
