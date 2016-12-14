<?php

namespace App\Repositories;

use App\Presenters\KoperasiPresenter;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\KoperasiRepository;
use App\Model\Koperasi;
use App\Validators\KoperasiValidator;

/**
 * Class KoperasiRepositoryEloquent
 * @package namespace App\Repositories;
 */
class KoperasiRepositoryEloquent extends BaseRepository implements KoperasiRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Koperasi::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return KoperasiValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function presenter()
    {
        return KoperasiPresenter::class;
    }
}
