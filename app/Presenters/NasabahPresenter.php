<?php

namespace App\Presenters;

use App\Transformers\NasabahTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class NasabahPresenter
 *
 * @package namespace App\Presenters;
 */
class NasabahPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new NasabahTransformer();
    }
}
