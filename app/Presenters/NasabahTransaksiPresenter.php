<?php

namespace App\Presenters;

use App\Transformers\NasabahTransaksiTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class NasabahTransaksiPresenter
 *
 * @package namespace App\Presenters;
 */
class NasabahTransaksiPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new NasabahTransaksiTransformer();
    }
}
