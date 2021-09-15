<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidateRole implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return ($value == 'employee' || $value == 'mis_office_personnel' || $value == 'supply_office_personnel') ? true : false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Enter a valid role.';
    }
}
