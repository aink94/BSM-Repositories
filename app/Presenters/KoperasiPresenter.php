<?php

namespace App\Presenters;

use App\Transformers\KoperasiTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class KoperasiPresenter
 *
 * @package namespace App\Presenters;
 */
class KoperasiPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new KoperasiTransformer();
    }
}
