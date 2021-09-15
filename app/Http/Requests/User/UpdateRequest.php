<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

use App\Rules\ValidateUniqueEmail;
use App\Auth\Gate\Gate;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>'required',
            'email'=>['required', 'email', new ValidateUniqueEmail($this->user)],
            'image'=>'image|max:2020',
        ];
    }
}
