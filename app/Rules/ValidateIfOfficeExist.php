<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

use App\DBQueries\Department;

class ValidateIfOfficeExist implements Rule
{
    use Department;
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
        return $this->first_department('department_name', '`department_name` = "'. $value. '"') ? true : false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Office does not exist.';
    }
}
