<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class KoperasiValidator extends LaravelValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
		'nama'	=>'	required',
		'token'	=>'	required',
		'key'	=>'	required',
	],
        ValidatorInterface::RULE_UPDATE => [
		'nama'	=>'	required',
	],
   ];
}
