<?php

namespace App\Presenters;

use App\Transformers\TransaksiTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class TransaksiPresenter
 *
 * @package namespace App\Presenters;
 */
class TransaksiPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new TransaksiTransformer();
    }
}
