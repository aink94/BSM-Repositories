<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class JenisTransaksiValidator extends LaravelValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
		''	=>'	required',
	],
        ValidatorInterface::RULE_UPDATE => [
		''	=>'	required',
	],
   ];
}
