<?php

namespace App\Http\Controllers;

use App\Criteria\OrderByTanggalCriteria;
use App\Presenters\DetailTransaksiNasabahPresenter;
use App\Presenters\NasabahTransaksiPresenter;
use App\Repositories\TransaksiRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Repositories\NasabahRepository;
use App\Validators\NasabahValidator;


class NasabahController extends Controller
{

    /**
     * @var NasabahRepository
     */
    protected $repository;

    /**
     * @var NasabahValidator
     */
    protected $validator;

    public function __construct(NasabahRepository $repository, NasabahValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $nasabahs = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $nasabahs,
            ]);
        }

        return view('nasabah', compact('nasabahs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  NasabahCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $nasabah = $this->repository->create($request->all());

            $response = [
                'message' => 'Nasabah created.',
                'data'    => $nasabah,
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ], 422);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $nasabah = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $nasabah,
            ]);
        }

        return view('nasabahs.show', compact('nasabah'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function lihatdetail($id, TransaksiRepository $transaksi)
    {
        //$this->repository->skipPresenter(true);
        $this->repository->setPresenter(NasabahTransaksiPresenter::class);
        $nasabah = $this->repository->find($id);
        //$transaksi->skipPresenter(true);
        $transaksi->setPresenter(DetailTransaksiNasabahPresenter::class);
        $transaksi->pushCriteria(OrderByTanggalCriteria::class);
        $transaksi = $transaksi->findWhere(['nasabah_id'=>$nasabah['data']['id']]);

        if (request()->wantsJson()) {

            $t['data'] = [
                'tanggal' => '',
                'jumlah' => '',
                'saldo' => 0,
                'jenis_transaksi' => ''
            ];

            return response()->json([
                'nasabah' => $nasabah,
                'transaksi' => (!empty($transaksi)) ? $transaksi : $t,
                'saldo_akhir' => (!empty($transaksi['data'])) ? $transaksi['data'][0]['saldo'] : 0,//saldo terakhir
            ], 200);
        }

        return view('nasabahs.lihatdetail', compact('nasabah'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  NasabahUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(Request $request, $id)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $nasabah = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Nasabah updated.',
                'data'    => $nasabah,
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'Nasabah deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Nasabah deleted.');
    }
}
