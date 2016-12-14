<?php

namespace App\Presenters;

use App\Transformers\JenisTransaksiTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class JenisTransaksiPresenter
 *
 * @package namespace App\Presenters;
 */
class JenisTransaksiPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new JenisTransaksiTransformer();
    }
}
