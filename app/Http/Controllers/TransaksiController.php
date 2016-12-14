<?php

namespace App\Http\Controllers;

use App\Criteria\OrderByTanggalCriteria;
use App\Criteria\PegawaiLoginCriteria;
use App\Criteria\TanggalSekarangCriteria;
use App\Criteria\TransaksiPegawaiSekarangCriteria;
use App\Events\NasabahTransaksiEvent;
use App\Model\Koperasi;
use App\Model\Nasabah;
use App\Repositories\KoperasiRepository;
use App\Repositories\NasabahRepository;
use App\Validators\BelanjaValidator;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Repositories\TransaksiRepository;
use App\Validators\TransaksiValidator;


class TransaksiController extends Controller
{

    /**
     * @var TransaksiRepository
     */
    protected $repository;

    /**
     * @var TransaksiValidator
     */
    protected $validator;

    public function __construct(TransaksiRepository $repository, TransaksiValidator $validator)
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
        $this->repository->pushCriteria(OrderByTanggalCriteria::class);
        $this->repository->pushCriteria(TanggalSekarangCriteria::class);
        $this->repository->pushCriteria(PegawaiLoginCriteria::class);
        $transaksis = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $transaksis,
            ]);
        }

        //Carbon::setLocale(config('app.locale'));
        //echo Carbon::now();//->format('Y-m-d');
        return view('transaksi', compact('transaksis'));
    }


    public function simpan(Request $request, TransaksiRepository $nasabah)
    {
        try{
            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $nasabah_id = $request->nasabah_id;
            $jumlah     = $request->jumlah;

            $this->repository->skipPresenter(true);
            $this->repository->pushCriteria(OrderByTanggalCriteria::class);
            $this->repository->scopeQuery(function($q) use ($nasabah_id){
                $q->where(['nasabah_id'=>$nasabah_id]);
                return $q;
            });
            $saldo = $this->repository->first();

            $simpan = [
                "tanggal"            => Carbon::now(),
                "saldo"              =>  (empty($saldo)) ? $jumlah : intval($saldo['saldo']) + $jumlah ,
                "jumlah"             => intval($jumlah),
                "pegawai_id"         => Auth::user()->id,
                "jenis_transaksi_id" => 1,//id penyimpanan
                "nasabah_id"         => $nasabah_id
            ];

            $transaksi = $this->repository->create($simpan);

            $event = [
                'nama_koperasi' => $simpan['pegawai_id'],
                'nama_nasabah' => $simpan['nasabah_id'],
                'tanggal_transaksi' => $simpan['tanggal'],
                'jumlah_transaksi' => $simpan['jumlah'],
                'jenis_transaksi' => $simpan['jenis_transaksi_id']
            ];

            event(new NasabahTransaksiEvent($event));

            $response = [
                'message' => 'Transaksi Simpan created.',
                'data'    => $simpan,
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

        }catch (ValidatorException $e){
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ], 422);
            }
        }
    }

    public function tarik(Request $request)
    {
        try{

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $nasabah_id = $request->nasabah_id;
            $jumlah     = $request->jumlah;

            $this->repository->skipPresenter(true);
            $this->repository->pushCriteria(OrderByTanggalCriteria::class);
            $this->repository->scopeQuery(function($q) use ($nasabah_id){
                $q->where(['nasabah_id'=>$nasabah_id]);
                return $q;
            });
            $saldo = $this->repository->first();

            if(intval($saldo['saldo']) < $jumlah)
                return response()->json(["message"=>"Saldo Tidak Cukup"], 402);

            $tarik = [
                "tanggal"            => Carbon::create(),
                "saldo"              =>  intval($saldo['saldo']) - $jumlah,
                "jumlah"             => $jumlah,
                "pegawai_id"         => Auth::user()->id,
                "jenis_transaksi_id" => 2,//id penarikan
                "nasabah_id"         => $nasabah_id
            ];

            $transaksi = $this->repository->create($tarik);

            $event = [
                'nama_koperasi' => $tarik['pegawai_id'],
                'nama_nasabah' => $tarik['nasabah_id'],
                'tanggal_transaksi' => $tarik['tanggal'],
                'jumlah_transaksi' => $tarik['jumlah'],
                'jenis_transaksi' => $tarik['jenis_transaksi_id']
            ];

            event(new NasabahTransaksiEvent($event));

            $response = [
                'message' => 'Transaksi Tarik created.',
                'data'    => $transaksi,
            ];

            if ($request->wantsJson()) {

                return response()->json($response, 201);
            }

        }catch (ValidatorException $e){
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ], 422);
            }
        }
    }

    public function belanja(Request $request, NasabahRepository $nasabah, KoperasiRepository $koperasi, BelanjaValidator $validator)
    {
        if($request->wantsJson()){
            if(!$request->api_token){
                return response()->json(["message"=>'Token Not Found'], 422);
            }
            $koperasi->skipPresenter(true);
            $koperasi = $koperasi->findByField('api_token', $request->api_token)->first();

            if(!$koperasi){
                return response()->json(["message"=>'Koperasi Not Found'], 404);
            }

            try{
                $validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

                $jumlah = $request->jumlah;
                $no_referensi = $request->no_referensi;
                $uid = $request->uid;
                $nis = $request->nis;
                $koperasi_id = $koperasi['id'];

                //cek Nasabah By uid dan nis
                $nasabah->skipPresenter(true);
                $nasabah = $nasabah->scopeQuery(function($q) use($uid, $nis){
                    return $q->where(['uid'=>$uid, 'nis'=>$nis]);
                })->first();
                if(!$nasabah){
                    return response()->json(["message"=>'Nasabah Not Found'], 404);
                }
                $nasabah_id = $nasabah['id'];

                //cek saldo terakhir
                $this->repository->skipPresenter(true);
                $this->repository->pushCriteria(OrderByTanggalCriteria::class);
                $this->repository->scopeQuery(function($q) use ($nasabah_id){
                    $q->where(['nasabah_id'=>$nasabah_id]);
                    return $q;
                });
                $saldo = $this->repository->first();

                if(intval($saldo['saldo']) < $jumlah)
                    return response()->json(["message"=>"Jumlah Penarikan Melebihi Saldo yang ada"], 402);

                $belanja = [
                    "tanggal"            => Carbon::create(),
                    "saldo"              =>  intval($saldo['saldo']) - $jumlah,
                    "jumlah"             => $jumlah,
                    "koperasi_id"        => $koperasi_id,
                    "jenis_transaksi_id" => 3,//id belanja
                    "no_referensi"       => ($no_referensi) ? $no_referensi : NULL,//No referensi
                    "nasabah_id"         => $nasabah_id
                ];

                $transaksi = $this->repository->create($belanja);

                $event = [
                    'nama_koperasi' => $belanja['koperasi_id'],
                    'nama_nasabah' => $belanja['nasabah_id'],
                    'tanggal_transaksi' => $belanja['tanggal'],
                    'jumlah_transaksi' => $belanja['jumlah'],
                    'jenis_transaksi' => $belanja['jenis_transaksi_id']
                ];

                event(new NasabahTransaksiEvent($event));

                $response = [
                    'message' => 'Transaksi Belanja created.',
                    'data'    => $transaksi,
                ];

                return response()->json($response, 201);

            }catch (ValidatorException $e){
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ], 422);
            }
        }
    }

    public function belanja2(Request $request, Nasabah $nasabah, Koperasi $koperasi)
    {
        try{

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $belanja = [
                "tanggal"            => Carbon::create(),
                "saldo"              =>  9000,
                "jumlah"             => $request->jumlah,
                "koperasi_id"        => 1,
                "jenis_transaksi_id" => 3,//id belanja
                "nasabah_id"         => 1
            ];

            $transaksi = $this->repository->create($belanja);

            $event = [
                'nama_nasabah' => $nasabah->findOrFail($belanja['nasabah_id'])->nama,
                'nama_koperasi' => $koperasi->findOrFail($belanja['koperasi_id'])->nama,
                'tanggal_transaksi' => $belanja['tanggal'],
                'jumlah_transaksi' => $belanja['jumlah']
            ];

            event(new NasabahTransaksiEvent($event));

            $response = [
                'message' => 'Transaksi Tarik created.',
                'data'    => $transaksi,
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

        }
        catch (ValidatorException $e){
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ], 422);
            }
        }
    }

    /**
     * Cek Ke Data Base
     * @param uid dan nis
     */
    public function CekUidNis(Request $request, NasabahRepository $nasabah){

        if($request->wantsJson()){
            $cek = $request->only(['uid', 'nis']);
            $nasabah->skipPresenter(true);
            $nasabah = $nasabah->scopeQuery(function($q) use($cek){
                return $q->where($cek);
            })->first();

            if(!$nasabah)
                return response()->json(["message"=>"RFID ANDA TIDAK ADA DALAM DATABASE"], 400);

            $data = [
                "message" => "RFID Anda Terdaftar Di Dalam DataBase",
                "data"    => $nasabah
            ];

            return response()->json($data, 200);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  TransaksiCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(TransaksiCreateRequest $request)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $transaksi = $this->repository->create($request->all());

            $response = [
                'message' => 'Transaksi created.',
                'data'    => $transaksi->toArray(),
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
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transaksi = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $transaksi,
            ]);
        }

        return view('transaksis.show', compact('transaksi'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $transaksi = $this->repository->find($id);

        return view('transaksis.edit', compact('transaksi'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  TransaksiUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(TransaksiUpdateRequest $request, $id)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $transaksi = $this->repository->update($id, $request->all());

            $response = [
                'message' => 'Transaksi updated.',
                'data'    => $transaksi->toArray(),
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
                'message' => 'Transaksi deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Transaksi deleted.');
    }
}
