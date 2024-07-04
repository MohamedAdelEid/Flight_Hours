<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class UniqueFinancialNumber implements Rule
{
    public function passes($attribute, $value)
    {
        return count($value) === count(array_unique($value));
    }

    public function message()
    {
        return 'ادخل الموظف مره واحده فقط';
    }
}
