<?php

namespace App\Transformers;

use App\Model\Nasabah;
use League\Fractal\TransformerAbstract;

/**
 * Class NasabahTransaksiTransformer
 * @package namespace App\Transformers;
 */
class NasabahTransaksiTransformer extends TransformerAbstract
{

    /**
     * Transform the \NasabahTransaksi entity
     * @param \NasabahTransaksi $model
     *
     * @return array
     */
    public function transform(Nasabah $model)
    {
        return [
            'id'   => (int) $model->id,
            'nis'  => $model->nis,
            'nama' => $model->nama,
        ];
    }
}
