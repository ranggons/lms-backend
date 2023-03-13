<?php

namespace App\Http\Requests\Api\Rangon;

use Illuminate\Foundation\Http\FormRequest;

class OrganizationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'type' => ['nullable'],
            'address' => ['nullabled']
        ];
    }
}
