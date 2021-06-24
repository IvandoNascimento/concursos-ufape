<?php namespace App\Utils;

use Illuminate\Support\ServiceProvider;

class CelularValidation
{
    public function validate($attribute, $value, $parameters, $validator)
    {
        return $this->isValidate($attribute, $value);
    }

    protected function isValidate($attribute, $value)
    {
        return preg_match('/^\(\d{2}\)\s?\d{5}-\d{4}$/', $value) > 0 || preg_match('/^\(\d{2}\)\s?\d{4}-\d{4}$/', $value) > 0; 
    }
}