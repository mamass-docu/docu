<?php

namespace App\Http\Requests\Asset;

use Illuminate\Foundation\Http\FormRequest;

use App\Auth\Gate\Gate;
use App\Rules\ValidateIfUserNameExist;
use App\Rules\ValidateIfOfficeExist;

class StoreRequest extends FormRequest
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
        $rule=[
            'asset_name' => 'required',
            'name' => ['required', new ValidateIfUserNameExist()],
            'department_name' => ['required', new ValidateIfOfficeExist()],
            'precurement_date' => 'required',
            'asset_image'=>'image|max:2020',
        ];

        if ($this->type == 'ICT')
            $rule = array_merge($rule, [
                'brand' => 'required',
                'model' => 'required'
            ]);
        else
            $rule = array_merge($rule, [
                'processor' => 'required',
                'memory' => 'required',
                'video_card' => 'required',
                'lan_card' => 'required',
                'sound_card' => 'required',
                'hard_drive' => 'required',
                'optical_drive' => 'required',
                'monitor' => 'required',
                'mouse' => 'required',
                'keyboard' => 'required',
                'avr' => 'required'
            ]);
            
        return $rule;
    }
}
