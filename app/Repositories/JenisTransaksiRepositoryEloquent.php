<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\JenisTransaksiRepository;
use App\Model\JenisTransaksi;
use App\Validators\JenisTransaksiValidator;

/**
 * Class JenisTransaksiRepositoryEloquent
 * @package namespace App\Repositories;
 */
class JenisTransaksiRepositoryEloquent extends BaseRepository implements JenisTransaksiRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return JenisTransaksi::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return JenisTransaksiValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
