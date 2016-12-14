<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Model\Nasabah;

/**
 * Class NasabahTransformer
 * @package namespace App\Transformers;
 */
class NasabahTransformer extends TransformerAbstract
{

    /**
     * Transform the \Nasabah entity
     * @param \Nasabah $model
     *
     * @return array
     */
    public function transform(Nasabah $model)
    {
        return [
            'id'           => (int) $model->id,
            'uid'          => $model->uid,
            'nis'          => $model->nis,
            'nama'         => $model->nama,
            'status_kartu' => $model->status_kartu,
            'action'       =>  '<div class="btn-group pull-right">'.
                    '<button class="btn btn-warning btn-xs" data-id="'.$model->id.'" id="btn-lihat"><i class="fa fa-eye"></i></button>'.
                    '<button class="btn btn-success btn-xs" data-id="'.$model->id.'" id="btn-ganti"><i class="fa fa-credit-card"></i></button>'.
                    '<button class="btn btn-info btn-xs" data-id="'.$model->id.'" id="btn-ubah"><i class="fa fa-edit"></i></button>'.
                    '<button class="btn btn-danger btn-xs" data-id="'.$model->id.'" id="btn-hapus"><i class="fa fa-trash-o"></i></button>'.
                '</div>'
        ];
    }
}
