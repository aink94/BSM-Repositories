<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class PegawaiValidator extends LaravelValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
		'nama'	    => 'required',
		'username'	=> 'required|unique:pegawai',
		'password'	=> 'required',
		'status'	=> 'required'
	],
        ValidatorInterface::RULE_UPDATE => [
        'nama'	    => 'required',
        'username'	=> 'required',
        'password'	=> '',
        'status'	=> 'required'
	],
   ];
}
