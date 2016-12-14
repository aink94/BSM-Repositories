<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class NasabahValidator extends LaravelValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
		'uid'	       =>'required|unique:nasabah',
		'nis'	       =>'required|unique:nasabah',
		'nama'	       =>'required',
		'status_kartu' =>'required',
	],
        ValidatorInterface::RULE_UPDATE => [
		'nama'	      =>'required',
		'status_kartu'=>'required',
	],
   ];
}
