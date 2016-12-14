@extends('layouts.authentication')

@push('css')

@endpush

@push('js')
{{ Html::script('pages/login.js') }}
@endpush

@section('title', 'Login BSM')

@section('content')
    <div id="login-page">
        <div class="container">

            <div class="form-login">
                {{csrf_field()}}
                <h2 class="form-login-heading">Silahkan Login</h2>
                <div class="login-wrap">
                    <input type="text" class="form-control" name="username" placeholder="Username" autofocus>
                    <br>
                    <input type="password" class="form-control" name="password" placeholder="Password">
                    <br>
                    <button class="btn btn-theme btn-block" id="sign"><i class="fa fa-lock"></i> SIGN IN</button>
                </div>
            </div>
        </div>
    </div>
@endsection