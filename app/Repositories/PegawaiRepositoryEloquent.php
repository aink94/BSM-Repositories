<?php

namespace App\Repositories;

use App\Presenters\PegawaiPresenter;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PegawaiRepository;
use App\Model\Pegawai;
use App\Validators\PegawaiValidator;

/**
 * Class PegawaiRepositoryEloquent
 * @package namespace App\Repositories;
 */
class PegawaiRepositoryEloquent extends BaseRepository implements PegawaiRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Pegawai::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return PegawaiValidator::class;
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
        return PegawaiPresenter::class;
    }
}
