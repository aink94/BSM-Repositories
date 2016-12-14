<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Model\Koperasi;

/**
 * Class KoperasiTransformer
 * @package namespace App\Transformers;
 */
class KoperasiTransformer extends TransformerAbstract
{

    /**
     * Transform the \Koperasi entity
     * @param \Koperasi $model
     *
     * @return array
     */
    public function transform(Koperasi $model)
    {
        return [
            'id'    => (int) $model->id,
            'nama'  => $model->nama,
            'action'=> '<div class="btn-group pull-right">'.
                        '<button class="btn btn-info btn-xs" data-id="'.$model->id.'" id="btn-ubah"><i class="fa fa-edit"></i></button>'.
                        '<button class="btn btn-danger btn-xs" data-id="'.$model->id.'" id="btn-hapus"><i class="fa fa-trash-o"></i></button>'.
                    '</div>'
            //'created_at' => $model->created_at,
            //'updated_at' => $model->updated_at
        ];
    }
}
