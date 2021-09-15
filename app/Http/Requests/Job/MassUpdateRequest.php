<?php

namespace App\Http\Requests\Job;

use Illuminate\Foundation\Http\FormRequest;

use App\Rules\ValidateIfAssetIdExist;
use App\Rules\ValidateIfUserNameExist;

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
            'serviceable_asset_id.*' => ['required', new ValidateIfAssetIdExist()],
            'service_type.*' => 'required',
            'client_contact_no.*' => 'required',
            'name.*' => ['required', new ValidateIfUserNameExist()],
            'request_date.*' => 'required',
            'request_time.*' => 'required',
        ];
    }
}
