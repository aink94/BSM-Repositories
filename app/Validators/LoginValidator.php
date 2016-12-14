<?php
/**
 * Created by PhpStorm.
 * User: Faisal Abdul Hamid
 * Date: 08/12/2016
 * Time: 6:57
 */

namespace App\Validators;


use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class LoginValidator extends LaravelValidator
{
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'username' => 'required',
            'password' => 'required'
        ]
    ];
}