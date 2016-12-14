<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class TransaksiValidator extends LaravelValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
		'jumlah'	=>'	required',
	],
        ValidatorInterface::RULE_UPDATE => [
		'jumlah'	=>'	required',
	],
   ];
}
