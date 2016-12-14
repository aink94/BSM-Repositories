<?php

namespace App\Http\Controllers;

use App\Criteria\OrderByTanggalAscCriteria;
use App\Criteria\TanggalSekarangCriteria;
use App\Presenters\NotifikasiPresenter;
use App\Repositories\TransaksiRepository;

class MainController extends Controller
{
    public function __construct()
    {
        
    }

    public function index()
    {
        return view('main');
    }

    public function notif(TransaksiRepository $repository, NotifikasiPresenter $presenter){
        $repository->pushCriteria(OrderByTanggalAscCriteria::class);
        $repository->pushCriteria(TanggalSekarangCriteria::class);
        $repository->setPresenter($presenter);
        $notif = $repository->all();

        if(request()->wantsJson()){

            return response()->json([
                'notif' => $notif
            ]);
        }
    }
}
