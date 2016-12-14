<?php

namespace App\Presenters;

use App\Transformers\NotifikasiTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class NotifikasiPresenter
 *
 * @package namespace App\Presenters;
 */
class NotifikasiPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new NotifikasiTransformer();
    }
}
