<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Model\Koperasi;
use App\Model\Pegawai as Users;
use App\Validators\LoginValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthenticationController extends Controller
{
    protected $validator;
    public function __construct(LoginValidator $validator)
    {
        $this->validator = $validator;
    }

    public function getLogin()
    {
        return view('login');
    }

    public function postLogin(Request $request, Users $user)
    {
        try{
            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            if($request->wantsJson()){
                $credential = $request->only('username', 'password');
                if(!Auth::attempt($credential, $request->has('remember'))){
                    return Response()
                        ->json(['title'=>'errors', 'message'=> 'Username atau Password yang anda masukan salah'], 401);
                }

                $user = $user->find(Auth::user()->id);

                return Response()
                    ->json(['title'=>'Success Login', 'message'=> 'Anda Berhasil Login','intended'=> URL::route('main')], 201);
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

    public function logout()
    {
        Auth::logout();
        return redirect()->route('get.login');
    }
}
