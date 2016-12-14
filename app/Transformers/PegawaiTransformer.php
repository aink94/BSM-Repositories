<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Model\Pegawai;

/**
 * Class PegawaiTransformer
 * @package namespace App\Transformers;
 */
class PegawaiTransformer extends TransformerAbstract
{

    /**
     * Transform the \Pegawai entity
     * @param \Pegawai $model
     *
     * @return array
     */
    public function transform(Pegawai $model)
    {
        return [
            'id'           => (int) $model->id,
            'nama'         => $model->nama,
            'username'     => $model->username,
            'status'       => $model->status,
            //'tanggal'      => $model->create_at->diffForHumans(),
            'action'       => '<div class="btn-group pull-right">'.
                                '<button class="btn btn-info btn-xs" data-id="'.$model->id.'" id="btn-ubah"><i class="fa fa-edit"></i></button>'.
                                '<button class="btn btn-danger btn-xs" data-id="'.$model->id.'" id="btn-hapus"><i class="fa fa-trash-o"></i></button>'.
                               '</div>'
        ];
    }
}
