<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

use App\DBQueries\User;

class ValidateIfUserNameExist implements Rule
{
    use User;
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
        return $this->first_user('user_id', [],'name = "'. $value .'"') ? true : false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Name does not exist.';
    }
}
