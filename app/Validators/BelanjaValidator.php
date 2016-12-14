<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class BelanjaValidator extends LaravelValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'uid' => 'required',
            'nis' => 'required',
            'jumlah' => 'required',
        ],
        ValidatorInterface::RULE_UPDATE => [],
   ];
}
