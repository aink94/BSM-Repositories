<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Model\JenisTransaksi;

/**
 * Class JenisTransaksiTransformer
 * @package namespace App\Transformers;
 */
class JenisTransaksiTransformer extends TransformerAbstract
{

    /**
     * Transform the \JenisTransaksi entity
     * @param \JenisTransaksi $model
     *
     * @return array
     */
    public function transform(JenisTransaksi $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
