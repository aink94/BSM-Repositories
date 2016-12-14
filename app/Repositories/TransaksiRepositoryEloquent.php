<?php

namespace App\Repositories;

use App\Presenters\TransaksiPresenter;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\TransaksiRepository;
use App\Model\Transaksi;
use App\Validators\TransaksiValidator;

/**
 * Class TransaksiRepositoryEloquent
 * @package namespace App\Repositories;
 */
class TransaksiRepositoryEloquent extends BaseRepository implements TransaksiRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Transaksi::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return TransaksiValidator::class;
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
        return TransaksiPresenter::class;
    }
}
