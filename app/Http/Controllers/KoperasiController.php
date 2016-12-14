<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\KoperasiCreateRequest;
use App\Http\Requests\KoperasiUpdateRequest;
use App\Repositories\KoperasiRepository;
use App\Validators\KoperasiValidator;


class KoperasiController extends Controller
{

    /**
     * @var KoperasiRepository
     */
    protected $repository;

    /**
     * @var KoperasiValidator
     */
    protected $validator;

    public function __construct(KoperasiRepository $repository, KoperasiValidator $validator)
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
        $koperasis = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $koperasis,
            ]);
        }

        return view('koperasi', compact('koperasis'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  KoperasiCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $koperasi = $this->repository->create($request->all());

            $response = [
                'message' => 'Koperasi created.',
                'data'    => $koperasi,
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
        $koperasi = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $koperasi,
            ]);
        }

        return view('koperasis.show', compact('koperasi'));
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

        $koperasi = $this->repository->find($id);

        return view('koperasis.edit', compact('koperasi'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  KoperasiUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(Request $request, $id)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $koperasi = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Koperasi updated.',
                'data'    => $koperasi,
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
                'message' => 'Koperasi deleted.',
                'data' => $deleted,
            ], 201);
        }

        //return redirect()->back()->with('message', 'Koperasi deleted.');
    }
}
