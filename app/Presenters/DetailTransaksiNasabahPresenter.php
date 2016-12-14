<?php

namespace App\Presenters;

use App\Transformers\DetailTransaksiNasabahTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class DetailTransaksiNasabahPresenter
 *
 * @package namespace App\Presenters;
 */
class DetailTransaksiNasabahPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new DetailTransaksiNasabahTransformer();
    }
}
