<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

use App\Rules\validateUserPassword;
use App\Auth\Gate\Gate;

class UpdatePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return  $this->user == $GLOBALS['user']->user_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_current_password'=>['required', new ValidateUserPassword()],
            'user_new_password'=>'required|min:8',
            'user_confirm_new_password'=>'required|same:user_new_password',
        ];
    }
}
