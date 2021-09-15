<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

use App\Rules\ValidateIfOfficeExist;
use App\Rules\ValidateRole;

class MassUpdateRequest extends FormRequest
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
            'name.*' => 'required',
            'department_name.*' => ['required', new ValidateIfOfficeExist()],
            'role.*' => ['required', new ValidateRole()],
            'user_image.*' => 'max:2020',
        ];
    }

    public function messages()
    {
        return [
            'name.*.required' => 'Name is required.',
            'department_name.*.required' => 'Department Name is required.',
            'role.*.required' => 'Role is required.',
            'user_image.*.max' => 'Image must be below 2020 bytes.',
        ];
    }
}
