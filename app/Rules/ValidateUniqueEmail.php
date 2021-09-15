<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

use App\DBQueries\User;

class ValidateUniqueEmail implements Rule
{
    use User;

    protected $user_id;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($user_id)
    {
        $this->user_id = $user_id;
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
        return $this->first_user('user_id', [], '`email` = "'. $value .'" AND `user_id` != "'. $this->user_id .'"') ? false : true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The email already exist.';
    }
}
