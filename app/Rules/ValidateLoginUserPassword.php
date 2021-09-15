<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

use App\DBQueries\User;
use Illuminate\Support\Facades\Hash;

class ValidateLoginUserPassword implements Rule
{
    use User;

    protected $email;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($email)
    {
        $this->email = $email;
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
        $user = $this->first_user('password', [], 'email = "'. $this->email .'"');
        
        if ($user)
            return Hash::check($value, $user->password);
        
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Password is incorrect.';
    }
}
