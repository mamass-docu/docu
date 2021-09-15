<?php

namespace App\Http\Requests\Asset;

use Illuminate\Foundation\Http\FormRequest;

use App\Rules\ValidateIfUserNameExist;
use App\Rules\ValidateIfOfficeExist;

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
            'asset_name.*' => 'required',
            'name.*' => ['required', new ValidateIfUserNameExist()],
            'department_name.*' => ['required', new ValidateIfOfficeExist()],
            'precurement_date.*' => 'required',
            'asset_image.*' => 'max:2020',
            // 'processor.*' => 'required',
            // 'memory.*' => 'required',
            // 'video_card.*' => 'required',
            // 'lan_card.*' => 'required',
            // 'sound_card.*' => 'required',
            // 'hard_drive.*' => 'required',
            // 'optical_drive.*' => 'required',
            // 'monitor.*' => 'required',
            // 'mouse.*' => 'required',
            // 'keyboard.*' => 'required',
            // 'avr.*' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'asset_name.*.required' => 'Assets name is required.',
            'name.*.required' => 'Name is required.',
            'department_name.*.required' => 'Office is required.',
            'precurement_date.*.required' => 'Precurement Date is required.',
            'asset_image.*.max'=>'Image is must below 2020 bytes.',
            // 'brand.*.required' => 'Brand is required.',
            // 'model.*.required' => 'Model is required.',
            // 'processor.*.required' => 'Processor is required.',
            // 'memory.*.required' => 'Memory is required.',
            // 'video_card.*.required' => 'Video Card is required.',
            // 'lan_card.*.required' => 'LAN Card is required.',
            // 'sound_card.*.required' => 'Sound Card is required.',
            // 'hard_drive.*.required' => 'Hard Drive is required.',
            // 'optical_drive.*.required' => 'Optical Drive is required.',
            // 'monitor.*.required' => 'Monintor is required.',
            // 'mouse.*.required' => 'Mouse is required.',
            // 'keyboard.*.required' => 'Keyboard is required.',
            // 'avr.*.required' => 'AVR is required.',
        ];
    }
}
