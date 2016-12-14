<?php

namespace App\Presenters;

use App\Transformers\PegawaiTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class PegawaiPresenter
 *
 * @package namespace App\Presenters;
 */
class PegawaiPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new PegawaiTransformer();
    }
}
