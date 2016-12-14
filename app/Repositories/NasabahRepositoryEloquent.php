<?php

namespace App\Repositories;

use App\Presenters\NasabahPresenter;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\NasabahRepository;
use App\Model\Nasabah;
use App\Validators\NasabahValidator;

/**
 * Class NasabahRepositoryEloquent
 * @package namespace App\Repositories;
 */
class NasabahRepositoryEloquent extends BaseRepository implements NasabahRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Nasabah::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return NasabahValidator::class;
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
        return NasabahPresenter::class;
    }
}
