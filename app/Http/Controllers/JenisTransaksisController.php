<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\JenisTransaksiCreateRequest;
use App\Http\Requests\JenisTransaksiUpdateRequest;
use App\Repositories\JenisTransaksiRepository;
use App\Validators\JenisTransaksiValidator;


class JenisTransaksisController extends Controller
{

    /**
     * @var JenisTransaksiRepository
     */
    protected $repository;

    /**
     * @var JenisTransaksiValidator
     */
    protected $validator;

    public function __construct(JenisTransaksiRepository $repository, JenisTransaksiValidator $validator)
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
        $jenisTransaksis = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $jenisTransaksis,
            ]);
        }

        return view('jenisTransaksis', compact('jenisTransaksis'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  JenisTransaksiCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(JenisTransaksiCreateRequest $request)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $jenisTransaksi = $this->repository->create($request->all());

            $response = [
                'message' => 'JenisTransaksi created.',
                'data'    => $jenisTransaksi->toArray(),
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
        $jenisTransaksi = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $jenisTransaksi,
            ]);
        }

        return view('jenisTransaksis.show', compact('jenisTransaksi'));
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

        $jenisTransaksi = $this->repository->find($id);

        return view('jenisTransaksis.edit', compact('jenisTransaksi'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  JenisTransaksiUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(JenisTransaksiUpdateRequest $request, $id)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $jenisTransaksi = $this->repository->update($id, $request->all());

            $response = [
                'message' => 'JenisTransaksi updated.',
                'data'    => $jenisTransaksi->toArray(),
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
                'message' => 'JenisTransaksi deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'JenisTransaksi deleted.');
    }
}
